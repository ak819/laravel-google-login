## setup

<p>1. run composer install</p>
<p>2. create database as per name mention in .env
<p>3. run php artisan migrate</p>
<p>4. run php artisan serve </p>

## routes details

<p>Home user details : http://127.0.0.1:8000/home </p>
<p>Login: http://127.0.0.1:8000/login</p>
<p>Regiserr: http://127.0.0.1:8000/register</p>

##note

<p>we are using current ip to get location details on local ($request->ip()=127.0.0.1)</p>
<p>that why i am declared variale $ip with my current ip value</p>
<p> if  we are going to user live server the uncomment UserController@index $ip=$request->ip(); </p>
<p> other wise on local we can replace current ip value UserController@index $ip={ current_ip}</p>
