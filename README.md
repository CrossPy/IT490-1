# Sports Betting Application

This repository contains all of the code necesarry to run our sports betting application. This was created as a project for the IT490 course at NJIT. Using fake currency, users are able to make bets on games within 3 of the most popular sports; NFL, MLB, and the NBA. Below you can see technologies used in the project.

  - Front End: PHP, HTML, CSS (Bootstrap), JavaScript
  - Backend: PHP, Python
  - Technologies: RabbitMQ, MySQL, nginx
  - Sports Data Source: MySportsFeeds

# Installation / Requirements

  - We do not have full installation scripts at the ready, but the usage is quite straight forward.
  - The repository is split up into sections based on the server that the pertaining code should be run. e.g. "db" contains all of the code which runs on the database server.
  - Tested to be fully working on  Ubuntu 16.04 LTS servers.
  - Install nginx
  - Install PHP dependencies on both webserver and backend database server (using composer.)
  - The rabbitMQ server must be configured with the provided configuration.
  - RabbitMQ.ini configuration files must be modified to reflect address scheme of the cluster being used.


# /vcs

The /vcs directory contains simple shell scripts that use rsync for version control. This was used in  development for making changes, creating releases, and pushing those releases to the different clusters. 



This text you see here is *actually* written in Markdown! To get a feel for Markdown's syntax, type some text into the left window and watch the results in the right.

# MySportsFeed

We would like to cordially thank the developers of MySportsFeeds for providing us with API access free of use for this educational project. Check their Github: https://github.com/MySportsFeeds/mysportsfeeds-api

# Contributors
- Eddie Fiorentine: https://github.com/edman80
- Omer Amin: https://github.com/OANJIT
- Steve St. Edwards: https://github.com/sms46
- Nick Rocha: no github :-(
