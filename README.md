
# WooX Travel Web Application
Problem: First time visitors in Ghana love exploration, unfortunately, not many persons have options of where to visit or where to get good information as to how their trips and stays can be managed effectively.

Solution: WooX Travel is a web application for managing travel bookings. This is designed for frequent travelers and travel agencies, with features such as booking management and reservation tracing. Users can book and delete their reservations at will. Travel managers can now add trips on interesting places to visit based on regions, landmark and cities in Ghana with preferred prices. For the scope of this project, a payment feature is not added rather a price is fixed and all calculations done.

Whether you're a frequent traveler or planning a once-in-a-lifetime trip, this app aims to streamline your travel experience.



# Author

- [Favour Madubuko](https://www.github.com/favouralgo)


# Features

- User Authentication: Secure login and registration for users and administrators.
- Location-based reservation booking: Search for and book places to visit with real-time availability.
- Itinerary Management: Create and manage travel itineraries, including regions, cities, landmark and prices.
- Admin Dashboard: Manage users, view reservation bookings, confirm bookings and oversee system operations. 
- Role Management: Admins can manage user roles and permissions.


# Tech Stack

LAMP stack was used

**Client:** HTML/CSS, JavaScript, jQuery

**Server:** MariaDB, Apache, PHP


# Installation

## Pre-requisites
Before you begin, ensure you have the following installed:

- [ ]  PHP 7.4 or higher
- [ ]  MySQL or MariaDB
- [ ]  Composer (for PHP dependency management, if any)

## Clone the repository

```bash
git clone https://github.com/yourusername/travel-management-app.git
cd travel-management-app
```

## For PHP Dependencies
```bash
composer install
```

## Create the database
```bash 
mysql -u username -p database_name < database/schema.sql
```

## Run migrations (if you use them)
```bash 
php artisan migrate
```

## Start the application (for PHP built-in server)
```bash 
php -S 51.20.181.20:8000 -t public
```




    
# Usage (Access the application on your local machine)

```javascript
Go to `http://51.20.181.20:8000` (or the URL where your server is running).
```


# Deployment

Deployed on AWS EC2 and can be accessed here: http://51.20.181.20/wooxtravel/




# Lessons Learned

- Spend 50% of the time thinking of the database for any application that should be built. 30% on ensuring the pixels are okay and the rest of the percentage on implementing. Life would be much easier.

- File path error is a burden. It can make you sleep while dreaming of your code. 

- A third eye is always good, no-one knows it all. If we knew, we would not be learning.

- I encountered errors while trying the unit testing. I should focus more on learning how to do it well. Very challenging for me.


# Acknowledgements

 - [Theme Wagon for templates](https://themewagon.com)




# Contributions

Contributions are always welcome after August!

Please send a hi to: favourmdev@gmail.com (remember to add the wave icon)


