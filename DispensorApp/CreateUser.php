
<!DOCTYPE html>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreateUser</title>
    <meta name="description" content="Page used by admin to create new users">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    </head>

    <body>
        <header>
            <div>
                <img src="logo.png" alt="Logo" width="100">
            </div>
            <nav>
                <ul>
                    <li><a href="#">AdminMenu</a></li>
                </ul>
            </nav>
        </header>
        <form  action="connection.php" method="POST">
            <div>
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName"required >
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required >
                <br><br>

                <div>
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="" selected disabled hidden class=""></option>
                        <option value="male">male</option>
                        <option value="female">female</option>
                        <option value="other">other</option>
                    </select>
                    <br><br>
                </div>
                
                <label for="ID">ID:</label>
                <input type="text" id="ID" name="ID" required >
                <br><br>

                

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" >
                <br><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required >
                <br><br>

                <label for="phoneNumber">Phone Number:</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" required >
                <br><br>

                <div>
                    <label for="userID">Username:</label>
                    <input type="text" id="userID" name="userID" required>
                    <br><br>

                    <label for="password">Create Password:</label>
                    <input type="password" id="password" name="password" required >

                    <label for="password-confirmation">Confirm Password:</label>
                    <input type="password" id="password-confirmation" name="password-confirmation" required >
                    <br><br>
                </div>

                <div>
                    <input type="submit">
                    <input type="reset">
                </div>
                <br>

            </div>
            
        </form>
    </body>
</html>