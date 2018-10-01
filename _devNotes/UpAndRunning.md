# Getting your dev environment up and running

## Requirements

### Docker

The dev environment for this project makes use of Docker. If running Linux or macOS, you can straight up run Docker native on your machine. For Windows, you _can_ run Docker native, however if you have other projects using Vagrant/Virtual Box, it is recommended that you use Docker Machine since Docker for Windows requires HyperV settings that are incompatible with Vagrant/Virtual Box and in fact make Windows BSOD.

## Getting the Dev Environment Running

1. Duplicate `.env.sample` as `.env`
2. Add the `SECURITY_KEY` value to your .env file from an existing environment. (Never commit sensitive credentials)
3. This part is tricky. Docker MariaDB image gets completely befuddled without an existing `db` directory with certain files already in place. If you have another environment that has a `db` directory, copy that to this project. If not, ask to be provided with a starter `db` directory.
4. From the command line, navigate to this repository's root directory and run `docker-compose up -d`
5. Acquire a database dump from an existing environment or ask for one to be provided.
6. Run `docker exec -it --user root db-buzzingpixel bash` to gain shell access to the MariaDB container.
7. With your DB dump in the repository root directory, and in the MariaDB shell, run the following command to clear out the database completely:
    - `mysqldump -usite -psecret --add-drop-table --no-data site | grep ^DROP | mysql --init-command="SET SESSION FOREIGN_KEY_CHECKS=0;" -usite -psecret site --force`
8. Now import the database dump with the following command:
    - `gunzip < dumpfile.sql.gz | mysql -usite -psecret site`
10. You'll almost certainly want to acquire `public/uploads` from the an existing environment and place them in the same location in your local repo.
11. Modify your hosts file as follows:
    - If you're running Docker Machine (as recommended for Windows), your Docker Machine IP is probably: 192.168.99.100. As such, use the following hosts file entry:
        - `192.168.99.100 buzzingpixel.test`
    - If you're running Docker natively, use the following hosts file entry:
        - `127.0.0.1 buzzingpixel.test`
12. Install composer dependencies
    - Execute `docker exec -it --user root php-buzzingpixel bash` from the command line
    - You are now in the PHP container shell. Run `composer install --ignore-platform-reqs`
13. Grab the `config/license.key` file from an existing environment and place it in the same location in your local project
14. You should now be able to access the dev site at: http://buzzingpixel.test:35019

You should be up and running. To stop the docker dev environment at any time, run: `docker-compose down` from the repo root. To start it again, from the repo root run `docker-compose up -d`
