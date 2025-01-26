# Astaan_TV
## Project Summary
This project builds TV subscription system for Astaan TV. It offers the pane for the user registration, the subscription registration and channel services, and also a dashboard to diplay the summary of the services.

![image](https://github.com/user-attachments/assets/1dd82d04-cc46-42f1-997b-d7348f0abff7)


The index page:
![image](https://github.com/user-attachments/assets/826fa5de-d421-429d-9d9f-e227cd57451d)

The Dashboard Page:
![image](https://github.com/user-attachments/assets/cf77b39f-e467-4fb7-a3fe-64945d37c187)

The Subscriptions Page:
![image](https://github.com/user-attachments/assets/5ba3abda-15c7-4903-ae9d-2e429eac657e)


## The SQL Schema

``` PHP
CREATE TABLE `channel_services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

```
