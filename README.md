# Docker SimpleSAMLphp IdP

This project provides a simple, containerized SAML 2.0 Identity Provider (IdP) using Docker and SimpleSAMLphp. It is designed for local development, allowing developers to build and test SAML-based authentication flows for their applications without needing a complex, production IdP. It stands in for CWL, UBC's Shibboleth IdP, and behaves like it where that matters to an application: each app receives only the attributes it is registered for, and logout messages are signed.

## Getting Started

To get the IdP running on your local machine, you will need [Docker](https://www.docker.com/get-started) and [Docker Compose](https://docs.docker.com/compose/install/).

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/ubc/docker-simple-saml
    cd docker-simple-saml
    ```

2.  **Build and Run the Container:**
    ```bash
    docker-compose up -d --build
    ```
    This command will build the Docker image, start the container in the background, and generate a self-signed certificate and key in `./cert/` if they don't exist.

The SAML IdP will be available at `http://localhost:6122/simplesaml/`.

**The `../saml-test-client/cert` mount.** `docker-compose.yml` also mounts `../saml-test-client/cert`, a folder *beside* this clone, so that a newly generated IdP certificate is copied there for the companion `saml-test-client`. If that folder does not exist, Docker creates it (empty) when the container starts. If you don't use `saml-test-client`, you can delete that line from `docker-compose.yml`.

### Is it healthy?

The image has a health check: the container is `healthy` only when the IdP's metadata answers and carries both its entityID and its signing certificate.

```bash
docker-compose ps                          # STATUS shows (healthy)
docker inspect --format '{{.State.Health.Status}}' <container-name>
```

It is checked every 30 seconds, so a fresh container shows `starting` for up to a minute.

### Which SimpleSAMLphp is this?

The image installs the newest SimpleSAMLphp 2.x every time it is built (`simplesamlphp/simplesamlphp:^2.0`), on PHP 8.3. To see the version a build installed:

```bash
docker exec <container-name> grep -m1 '"version"' /var/www/simplesamlphp/composer.json
```

## Connecting an application

These are the IdP's endpoints (SimpleSAMLphp 2.x paths):

| | URL |
|---|---|
| entityID (the IdP's `Issuer`) | `http://localhost:6122/simplesaml/saml2/idp/metadata.php` |
| Single sign-on (`entryPoint`) | `http://localhost:6122/simplesaml/module.php/saml/idp/singleSignOnService` |
| Single logout (`logoutUrl`) | `http://localhost:6122/simplesaml/module.php/saml/idp/singleLogout` |
| Metadata | `http://localhost:6122/simplesaml/module.php/saml/idp/metadata` |
| Signing certificate | `./cert/server.crt` (or the `X509Certificate` in the metadata) |

The older `/simplesaml/saml2/idp/SSOService.php`, `SingleLogoutService.php` and `metadata.php` URLs still work too.

**[passport-ubcshib](https://github.com/ubc/passport-ubcshib) users: set `entryPoint` and `logoutUrl` yourself.** Its `LOCAL` preset (`SAML_ENVIRONMENT=LOCAL`) still points at `http://localhost:8080` and SimpleSAMLphp 1.x paths, which this IdP does not serve. For example:

```js
new Strategy(
  {
    issuer: 'http://localhost:8050', // must match an entityID in saml20-sp-remote.php
    callbackUrl: 'http://localhost:8050/auth/saml/callback', // must match its ACS
    entryPoint: 'http://localhost:6122/simplesaml/module.php/saml/idp/singleSignOnService',
    logoutUrl: 'http://localhost:6122/simplesaml/module.php/saml/idp/singleLogout',
    cert: fs.readFileSync('path/to/docker-simple-saml/cert/server.crt', 'utf8'),
    attributeConfig: ['ubcEduCwlPuid', 'mail', 'eduPersonAffiliation'],
  },
  verify,
);
```

### Attribute names: friendly here, OIDs from real CWL

This IdP sends attributes under their friendly names (`uid`, `mail`, `ubcEduCwlPuid`, ...). Real CWL sends them under OID names (`urn:oid:0.9.2342.19200300.100.1.3` for `mail`, `urn:oid:1.3.6.1.4.1.60.6.1.6` for `ubcEduCwlPuid`, ...). passport-ubcshib's `attributeConfig` maps both to the friendly names, so the same code works against both.

To test an app against CWL's naming, an SP can opt in to OID names: see [Releasing OID names](#releasing-oid-names-opt-in) below.

## Configuration

All configuration is handled through files in the `config/simplesamlphp/` directory, which is bind-mounted into the container. SimpleSAMLphp reads them on every request, so an edit takes effect without a rebuild.

### Environment variables

All optional. Set them in your shell or in a `.env` file beside `docker-compose.yml` (git ignores `.env`); `docker-compose.yml` passes them to the container. Unset or empty keeps the default.

| Variable | Default | What it sets |
|---|---|---|
| `IDP_ENTITY_ID` | `http://localhost:6122/simplesaml/saml2/idp/metadata.php` | The IdP's entityID, the same whatever host name or port it is reached on. Change it only if your SPs expect another value. |
| `SSP_ADMIN_PASSWORD` | `admin123` | The password for SimpleSAMLphp's admin pages (`/simplesaml/admin/`). |
| `SSP_SECRET_SALT` | `yoursupersecuresalthere` | SimpleSAMLphp's `secretsalt`. |

The defaults are public, which is fine for a local test IdP.

### Test Users

A default set of test users is provided. You can view, edit, or add new users in the following file:

-   **File:** `config/simplesamlphp/authsources.php`

It defines 35 test personas: 15 faculty, 15 students, 2 TAs (affiliated as both student and staff) and 3 staff. Most line up with the records the UBC Academic API fake (`FakeAcademicAPI`) seeds, covering cases such as an instructor who teaches nothing, a student with no email on their academic record, and someone with both an employee and a student number; each persona's comment says which. **Every password is the login name** (`faculty` / `faculty`, `bio_student` / `bio_student`, ...). Note that the original three, `faculty`, `student` and `staff`, release `uid` as `faculty-user`, `student-user` and `staff-user`.

Each persona's `eduPersonTargetedId` is a fixed placeholder (`http://localhost:6122!https://your-app!ID…`), not a value computed per SP as a real IdP's would be.

### Service Providers (Applications)

You can authorize your local applications to use this IdP by adding them as Service Providers (SPs). The configuration for allowed SPs is located in:

-   **File:** `config/simplesamlphp/saml20-sp-remote.php`

It lists each application's entityID (its `issuer`), Assertion Consumer Service (ACS) URL, single logout URL and **the attributes it receives**. The quickest way to add an app that follows the common layout (ACS at `/auth/saml/callback`, logout at `/auth/logout`) is a line in `$local_apps`:

```php
'http://localhost:8090' => 'http://localhost:8090', // entityID => base URL
```

If its ACS is elsewhere, override it after the loop, as the file already does for `http://localhost:6118`:

```php
$metadata['http://localhost:8090']['AssertionConsumerService'][0]['Location'] = 'http://localhost:8090/auth/ubcshib/callback';
```

#### Each app receives only its own attributes

Like real CWL, the IdP releases to each SP only the attributes listed in its entry's `attributes` (SimpleSAMLphp's `core:AttributeLimit`, in `config.php`). Apps in `$local_apps` receive `$default_attributes`:

`uid`, `eduPersonAffiliation`, `eduPersonPrincipalName`, `givenName`, `sn`, `ubcEduCwlPuid`, `mail`

To give one app more, give its entry its own list, for example after the loop:

```php
$metadata['http://localhost:8090']['attributes'] = array_merge( $default_attributes, array( 'cwlLoginName' ) );
```

Two things to avoid: an **empty** `attributes` list releases *everything*, and an entry with **no** `attributes` key falls back to the IdP's own list in `saml20-idp-hosted.php`. If your app reads an attribute it does not receive, add it to its list here. That is also what you will need to ask for when you register the app with CWL.

#### Releasing OID names (opt-in)

To have the IdP send an app UBC's real OID attribute names, merge `$ubc_oid_attribute_names` into its entry, after the entry is defined:

```php
$metadata['http://localhost:8090'] = array_merge( $metadata['http://localhost:8090'], $ubc_oid_attribute_names );
```

The entry's `attributes` list stays in **friendly** names: the limit runs first, on friendly names, and the rename to OIDs runs after it. (Doing it the other way round releases nothing at all.) `ubcEduCwlPuid` maps to `urn:oid:1.3.6.1.4.1.60.6.1.6` (`attributemap/ubcoid.php`); `cwlLoginName` has no confirmed OID and keeps its friendly name.

#### An app that signs its AuthnRequests

If your app signs its AuthnRequests (with passport-ubcshib, setting `privateKeyPath` does that), the IdP checks the signature, and the SP's entry must carry the app's certificate, or every sign-in is refused with *Missing certificate in metadata*:

```php
$metadata['http://localhost:8090']['certData'] = 'MIIC...'; // the app's certificate, base64, no PEM header lines
```

## Signing out, and switching test user

**Signing out of an app ends the app's session, not necessarily the IdP's.** While the IdP session lasts, the next sign-in at that browser skips the password and returns the same person. Two ways to end it:

- **From your app:** send the browser through the IdP's single logout, e.g. `http://localhost:6122/simplesaml/module.php/saml/idp/singleLogout?ReturnTo=http://localhost:8050/`. The IdP signs the person out of every app that has a logout endpoint, then returns to `ReturnTo`, which may be any `localhost` or `127.0.0.1` URL, on any port. The IdP's LogoutRequest and LogoutResponse messages are signed, as real CWL's are.
- **To switch test user by hand:** visit `http://localhost:6122/simplesaml/module.php/core/logout/example-userpass` (the IdP's front page, `http://localhost:6122/simplesaml/`, links to it), then sign in from your app again.

## Testing the IdP

Once the container is running, you can test its functionality:

1.  **IdP-Initiated Login Page:**

    -   Visit `http://localhost:6122/simplesaml/test-idp-init.php` for a simple test page.

2.  **A test user's attributes:**

    -   `http://localhost:6122/simplesaml/module.php/admin/test/example-userpass` asks for the admin password (`admin123` unless `SSP_ADMIN_PASSWORD` is set), then a test user's login, then shows every attribute that user has. (What an *app* receives is limited to its entry's list, above.)

3.  **Viewing Logs:**
    -   Log files are written to the `./log/` directory on your local machine. You can view the `simplesamlphp.log` file there to debug any issues.

## Metadata

-   **IdP Metadata:** You can find the IdP's metadata XML at `http://localhost:6122/simplesaml/module.php/saml/idp/metadata` (or the older `http://localhost:6122/simplesaml/saml2/idp/metadata.php`). This URL is typically provided to an SP during configuration.
