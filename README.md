# Docker SimpleSAMLphp IdP

This project provides a simple, containerized SAML 2.0 Identity Provider (IdP) using Docker and SimpleSAMLphp. It is designed for local development, allowing developers to build and test SAML-based authentication flows for their applications without needing a complex, production IdP.

## Getting Started

To get the IdP running on your local machine, you will need [Docker](https://www.docker.com/get-started) and [Docker Compose](https://docs.docker.com/compose/install/).

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/ubc/docker-simpl-saml
    cd docker-simple-saml
    ```

2.  **Build and Run the Container:**
    ```bash
    docker-compose up -d --build
    ```
    This command will build the Docker image, start the container in the background, and generate self-signed certificates if they don't exist.

The SAML IdP will be available at `http://localhost:8080/simplesaml/`.

## Configuration

All configuration is handled through files in the `config/simplesamlphp/` directory.

### Test Users

A default set of test users is provided. You can view, edit, or add new users in the following file:

-   **File:** `config/simplesamlphp/authsources.php`

The file contains definitions for a `faculty` and a `student` user, including their passwords and SAML attributes.

### Service Providers (Applications)

You can authorize your local applications to use this IdP by adding them as Service Providers (SPs). The configuration for allowed SPs is located in:

-   **File:** `config/simplesamlphp/saml20-sp-remote.php`

This file contains a list of application entity IDs and their corresponding Assertion Consumer Service (ACS) URLs.

## Testing the IdP

Once the container is running, you can test its functionality:

1.  **IdP-Initiated Login Page:**

    -   Visit `http://localhost:8080/simplesaml/test-idp-init.php` for a simple test page.

2.  **Direct Login Page:**

    -   To see the IdP's login screen directly, visit:
        `http://localhost:8080/simplesaml/module.php/core/authenticate.php?as=example-userpass`

3.  **Viewing Logs:**
    -   Log files are written to the `./log/` directory on your local machine. You can view the `simplesamlphp.log` file there to debug any issues.

## Metadata

-   **IdP Metadata:** You can find the IdP's metadata XML at `http://localhost:8080/simplesaml/saml2/idp/metadata.php`. This URL is typically provided to an SP during configuration.
