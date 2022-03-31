# LSocial

Important note: this graded exercise must be done individually.

Like all social media platforms such as Twitter, Facebook, Instagram, etc., the first thing a user has to do is to sign
up and log into the newly created account to use the features provided by the website. The aim of this exercise is to
implement the Register and Login pages using Slim framework and apply all the knowledge that we have acquired as until now.

## Pre-requisites

To be able to create this web app, you are going to need a local environment suited with:

1. Web server (Nginx)
2. PHP 8
3. MySQL
4. Composer

### Requirements

1. Use Slim as the underlying framework.
2. Create and configure services in the `dependencies.php` file. Examples of services are Controllers, Repositories, '
   view', 'flash', ...
3. Use Composer to manage all the dependencies of your application. There must be at least two dependencies.
4. Use Twig as the main template engine.
5. Use MySQL as the main database management system.
6. You MUST use the structures available in Object-Oriented Programming: Namespaces, Classes and Objects.

## Resources

### MySQL

Add your [schema.sql](./resources/schema.sql "Schema SQL") in `docker-entrypoint-initdb.d` folder to create the tables
in the MySQL database. 

## Exercise

To complete the exercise, you will need to create three different pages:

1. Register
2. Login
3. Homepage

### Register

This section describes the process of registering a new user into the system.

| Endpoints | Method |
|-----------|--------|
| /sign-up  | GET    |
| /sign-up  | POST   |

If the user is not logged in, the Register link is shown in the navigation menu in the header.

When a user accesses the **/sign-up** endpoint you need to display the registration form. The information of the form
must be sent to the same endpoint using a **POST** method. The registration form must contain the following inputs:

* email - required
* password - required
* repeat password - required
* birthday - optional

State explicitly the date format for birthday as the input field placeholder or next to the input field (e.g dd/MM/YYYY)
.

When a **POST** request is sent to the **/sign-up** endpoint, you must validate the information received from the form
and register the user only if all the validations have passed. The requirements for each field are as follows:

* email: It must be a valid email address. Only emails from the domain @salle.url.edu are accepted. The email must be
  unique among all users of the application.
* password: It must contain **more than** 5 characters. It must contain both upper and lower case letters. It must
  contain numbers. It must be stored using a hash algorithm.
* repeatPassword: It must be the same as password.
* birthday: The user must be 18 years old and above. It must be a valid date, and it is an optional.

If there is any error, you need to display the register form again. All the information entered by the user must be kept
and shown in the form together with all the errors below the corresponding inputs.

Here are the error messages that you need to show respectively:

* Only emails from the domain @salle.url.edu are accepted
* The email address is not valid
* The password must contain at least 6 characters
* The password must contain both upper and lower case letters and numbers
* Birthday is invalid
* Sorry, you are underage

Once the user's account is created, the system will now allow the user to sign in with the newly created credentials.

### Login

This section describes the process of logging into the system.

| Endpoints | Method |
|-----------|--------|
| /sign-in  | GET    |
| /sign-in  | POST   |

When a user accesses the **/sign-in** URL you need to display the sign-in form. The information of the form must be sent to
the same endpoint using a POST method. The sign-in form must contain the following inputs:

* email
* password

When the application receives a POST request in the **/sign-in** endpoint, it must validate the information received from
the form and if all the validations have passed, the system will try to log in the user. The validations of the inputs
must be exactly the same as in the registration.

If there is any error or if the user does not exist, you need to display the form again with all the information
provided by the user and display the corresponding error.

Here are the error messages that you need to show respectively:

* The password must contain at least 6 characters
* The password must contain both upper and lower case letters and numbers
* The email address is not valid
* User with this email address does not exist
* Your email and/or password are incorrect

As you can observe, some of these messages are the same as in the Register page. Think about how you structure your code
and make it reusable.

After logging in, the user will be redirected to the Homepage which is described in the next section.

### Homepage

This page simply shows a "Hello <username>!" message after the user has logged in. If the user tries to access the
Homepage without being authenticated first, the user must be redirected to the Login page.

## Tests

To check the validity of this exercise, we will be using [Cypress](https://www.cypress.io/). It is a Javascript
End-to-End Testing Framework. For the tests to work, we need to add custom attributes to HTML elements. The attributes
will follow the format:

```
data-cy=""
```

In the Register page, you MUST add the following attributes:

```
<form data-cy="sign-up">
    <input data-cy="sign-up__email">
    <input data-cy="sign-up__password">
    <input data-cy="sign-up__repeatPassword">
    <input data-cy="sign-in__birthday">
    <input data-cy="sign-up__btn">
    <span data-cy="sign-up__wrongEmail"></span>    // <span> can be a different element
    <span data-cy="sign-up__wrongPassword"></span> 
    <span data-cy="sign-up__wrongBirthday"></span> 
</form>
```

As you can see, the values are different for each input, including the form itself. Your HTML can have other elements
and attributes, but take note that these "data-cy" attributes must exist for the tests to work.

In the Login page, you MUST add the following attributes:

```
<form data-cy="sign-in">
    <input data-cy="sign-in__email">
    <input data-cy="sign-in__password">
    <input data-cy="sign-in__btn">
    <span data-cy="sign-up__wrongEmail"></span>    // <span> can be a different element
    <span data-cy="sign-up__wrongPassword"></span> 
</form>
```

In the Homepage, you MUST add the following attributes:

```
<h1 data-cy="home__welcomeMsg"></h1>
```

Another important thing to consider are the "endpoints". The endpoints described in the previous sections MUST be used
exactly as is. You cannot use **/register** or **/login**. These endpoints will make the tests fail.

If any of the given tests fails, then you will know which feature or validation does not work in your code.

NOTE: Do not modify the tests. Any modification in the tests will surely make the tests fail during the grading of your
deliverable.

## Delivery

### Format

You must upload a .zip file with the filename format `AC2_<your_login>.zip` containing all the code to the eStudy.