# REST API Example usage based on PHP and Vuejs
Example of REST API including PHP/Vuejs, OOP, MVC, Composer autoloader

### Directory Structure

```bash
app
│
├─ README.md
├─ composer.json       # Configuration for the PHP-composer
├─ docker-compose.yml  # Configuration for the Docker-composer
├─ nginx-api.conf      # Server configuration of the Nginx
├─ nginx-main.conf     # A configuration of Nginx daemon
├─ api                 # An entry point to the API (api.domain.loc)
├─ database            # Database files
├─ src                 # PHP files of the project
└─ vendor              # Directory for various libraries
```

### Docker Usage
```bash
# Serving:
$ docker-compose up

# Cleanup:
$ docker-compose down
```

Use [http://localhost:8000](http://0.0.0.0:8000/) address to see the result.

Specific domain usage:

Add record `172.72.0.3   api.domain.loc` into your `/etc/hosts` file on your host machine.
Then address [http://api.domain.loc:8000](http://api.domain.loc:8000/) should be available
