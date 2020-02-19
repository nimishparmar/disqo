# DISQO Coding Challenge by Nimish Parmar

Hello! Thank you for giving me the opportunity to work on this very exciting exercise. I truly had a blast working on various aspects of the project.

The coding challenge is hosted on AWS and the main entrypoint can be accessed here [http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com](http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com)

To login, please use one of the following credentials:

`email`: `nimish.parmar@gmail.com`
`password`: `nimishlovesdisqo`

or

`email`: `marco.huerta@disqo.com`
`password`: `marcolovesdisqo`

or

`email`: `drew@disqo.com`
`password`: `drewlovesdisqo`

Upon successful login, some of the search terms to be used are:

 - `book`
 - `management`


# Overall architecture

For the purpose of this exercise, I've focused on 2 core microservices - Authentication Service and Product service, in addition to a main user-facing web application. The breakdown of each service is as follows --

**Authentication Service**

This RESTful service acts as the main authentication source. The only endpoint that I've implemented is `/api/v1/login` which accepts a POST HTTP method with `email` and `password` as form data. Upon providing valid credentials, the service returns a JWT token. If invalid credentials are provided, the service returns an error.

The service is written in PHP 7.2 using [Lumen](https://lumen.laravel.com/) micro-framework with its own nginx and MySQL database. The service is hosted here [http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com:8000](http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com:8000) and the codebase for the service is here https://github.com/nimishparmar/disqo/tree/master/auth

The service is entirely dockerized and is running in its own instance.

**Product Service**

This RESTful service acts as the central repository of all products within the system. For the sake of this exercise, the only endpoint I've implemented is `/api/v1/search` which accepts a POST HTTP method with `search_term` as form data. I've implemented a simple text based search, which does a string matching against the product name and returns a set of matching records.

The service is written in PHP 7.2 using [Lumen](https://lumen.laravel.com/) micro-framework with its own nginx and MySQL database. The service is hosted here [http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com:7000](http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com:7000) and the codebase for the service is here https://github.com/nimishparmar/disqo/tree/master/product_service

The service is entirely dockerized and is running in its own instance.

**Web App**

This is the main user-facing web application. The login interface is hosted here, which interfaces with the Authentication Service. Upon successful login, the search functionality is also hosted here, which interfaces with the Product Service.

The service is written in PHP 7.2 using [Lumen](https://lumen.laravel.com/) micro-framework with its own nginx and does not have a database, since its only making REST API calls for data. The service is hosted here [http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com](http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com) and the codebase for the application is here https://github.com/nimishparmar/disqo/tree/master/app

The service is entirely dockerized and is running in its own instance.

Having well defined microservices with their own databases helps in scaling each service as needed. In production systems, each service could have a loadbalancer in front of it if needed. Separate teams of developers can focus independently on these services and deploy them independently as well. Monitoring, logging and alerting on each service provides fine grained real-time information in production systems.


# Proposed data model (for production)
![image](https://github.com/nimishparmar/disqo/blob/master/DISQO_E-Commerce_platform.png)

# High level systems integration
![image](https://github.com/nimishparmar/disqo/blob/master/DISQO_Systems_Diagram.png)


# High level technical roadmap
Here's a very high level technical roadmap, which takes into account the fact that each microservice and be developed somewhat independently than others. Each service can potentially be worked on by different teams of developers and have its own CI/CD pipeline, thereby enabling completely decoupled deployments, monitoring, logging and alerting.

As you notice, some of the tasks, such as (Cart/Cart Items + Quote/Quote Items and Auth Service + Receipts/Receipt Items + Web Client) can potentially be done in parallel by different teams.

I've used a very rough number of business days each subtask could take. [Here's](https://github.com/nimishparmar/disqo/blob/master/disqo-project-plan.pdf) a link to the pdf version of the image below

![image](https://github.com/nimishparmar/disqo/blob/master/disqo-project-plan.png)
