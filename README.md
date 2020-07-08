# Web-Based Clinic Appointment System

**Notes** : *for patient, no web based support only available at mobile based. Please checkout [here - Mobile-Based Clinic Appointment System](https://github.com/yh-ong/Mobile-Based-Clinic-Appointment-System)*

[TOC]

ClinicME will involve two platforms which are mobile application and web based. For the mobile application based will use Ionic framework developed to let patient to book an appointment by anywhere in anytime. In web based, the system will use HTML, CSS, Javascript, PHP and MySQL developed to let clinic administrator and doctor to manage the appointment and update the clinic and doctor information.

## Purpose
Aim at developing the clinic appointment apps to provide patients with a convenient way to make clinic appointment. This can minimise the hassle of patients having long queue in seeking consultation with the doctor and less interruption for clinic administrative officer during the peak hour. Besides that, a patient no longer needs to walk in and make a call to book an appointment. Thus, it brings convenience to patients.

## Features
In this project, contains 4 user-roles. Each users key features and functionalities listed as below:

#### Admin
- approve the clinic status for new registration
- view clinic/doctor/patient list
- add/edit/delete speciality

#### Doctor
- edit doctor information & password reset
- add sympton/diagnosis/advice in the database
- view & add follow up the appointments
- manage the available schedule
- add/edit/delete treatment type

#### Clinic
- add/edit/delete doctor
- add/edit clinic information
- add/edit clinic manager & password reset
- view appointment status & list
- make annoucement for patient

#### Patient (Android-Based)
- register as an patient account
- edit profile & password reset
- book & cancel an appointment
- view booking status
- view doctor availability
- search clinic & doctor with filter
- rate and review

**Notes** : *for patient, no web based support only available at mobile based. Please checkout [here - Mobile-Based Clinic Appointment System](https://github.com/yh-ong/Mobile-Based-Clinic-Appointment-System)*

## Technology
Clinic ME uses a number of technology to work properly:

#### Front-End
- HTML
- CSS
- Javascript
- JQuery
- Ajax

#### Back-End
- PHP 7.1.7
- MySQL

#### Plugin
- [Boostrap 4](https://www.chartjs.org/)
- [Bootstrap Datepicker](https://bootstrap-datepicker.readthedocs.io/en/stable/) or [github](https://github.com/uxsolutions/bootstrap-datepicker)
- [DataTables with Bootstrap 4](https://datatables.net/examples/styling/bootstrap4)
- [Owl Carousel](https://owlcarousel2.github.io/OwlCarousel2/)
- [SweetAlert 2](https://sweetalert2.github.io/)
- [Chart.js](https://www.chartjs.org/)

#### Software Requirement
- [XAMPP](https://www.apachefriends.org/index.html) or any web server with Apache & MySQL service
- Google Chrome (Recommended) & Mozila Firefox

## Usage
1. create a folder name as `doclab`, clone all the file inside the folder.
2. install **xampp** or **any web server tool** to your computer, and start `Apache` and `MySQL` services.
3. type `http://localhost/doclab/` to the web browser

### File Structure:
- **assets** folder contain all the resource of styles, scripts, images and fonts
- **config** folder contain a list of project configuration files
	- `autoload` : define the config filename, will autoload to the project
	- `config` : any of the configuration of the project such as timezon setting
	- `database` : connection of the localhost to the database of phpmyadmin
	- `path_css` : config the css path in the top of the html code
	- `path_script` : config the script path in the bottom of the html code
	- `security` : encryption & decryption, generate random password
	- `validator` : validation of all the input error message
- **helper** folder contain all the
- **uploads** folder contain all the upload image file
- **admin**, **clinic**, **doctor** and **patient** folder
	- `includes` : config or path of the files specfic with user&#39;s folder
	- `layouts` : contains the page layout style

**Notes** : **patient** only contain CRUD files all the return API format