<!DOCTYPE html>
    <html lang="en-US">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <style>
                .header{
                    position: relative;
                    height: 100px;
                    width: 100%;
                    background-color: #815186;
                    box-shadow: 0 0px 15px 0 rgba(0, 0, 0, 0.3);
                }
                
                .logo{
                    display: inline-block;
                    margin-top: 17px;
                    height: 66px;
                    width: 66px;
                }
                
                .logo a, .logo img{
                    height: 100%;
                    width: 100%;
                }
                
                .welcome-message{
                    position: absolute;
                    top: 40px;
                    left: 75px;
                    font-family: "Open Sans";
                    font-size: 20px;
                    line-height: 20px;
                    color: #fff;
                    display: inline-block;
                }
                
                .search{
                    position: absolute;
                    top: 29px;
                    left: 50%;
                    height: 42px;
                    display: flex;
                    width: 40%;
                    transform: translateX(-50%);
                    color: #888;
                }
                
                .search input{
                    width: calc(100% - 50px);
                    border: none;
                    box-sizing: border-box;
                    padding: 10px 12px;
                    font-family: "Open Sans";
                    font-size: 16px;
                }
                
                .search input:focus{
                    outline: none;
                }
                
                .search input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
                    color: #b9b9b9;
                }
                .search input::-moz-placeholder { /* Firefox 19+ */
                    color: #b9b9b9;
                }
                .search input:-ms-input-placeholder { /* IE 10+ */
                    color: #b9b9b9;
                }
                .search input:-moz-placeholder { /* Firefox 18- */
                    color: #b9b9b9;
                }
                
                .search button{
                    width: 50px;
                    text-align: center;
                    border: 0;
                    background: #fff;
                    color: #ddd;
                    cursor: pointer;
                    margin-left: -1px;
                }
                
                .search button:hover{
                    background: #fafafa;
                }
                
                .logout{
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    display: inline-block;
                    right: 0px;
                    color: #fff;
                }
                
                .logout button{
                    background-color: transparent;
                    color: #fff;
                    border: none;
                    text-align: center;
                }
                
                .logout span{
                    display: block;
                    margin-left: -10px;
                }
                
                @media only screen and (max-width:1200px){
                    .logo, .welcome-message{
                        margin-left: 10px; 
                    }
                    
                    .logout{
                        margin-right: 10px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="positioner" style="height: 100%;">
                    
                    <div class="logo">
                        <a href="./home.php">
                            <img src="./img/CKrJW_3UYAAYwRO.png" alt="Pollster">
                        </a>
                    </div>
                    
                    <div class="welcome-message">
                        Hello, <?php echo $firstname; ?>
                    </div>
                    
                    <div class="search">
                        <input type="text" placeholder="Search for topics, questions..">
                        <button><i class="fa fa-2x fa-search"></i></button>
                    </div>
                    
                    <div class="logout">
                        <button onclick="logout()"><i class="fa fa-3x fa-sign-out"></i><span>Logout</span></button>
                    </div>
                </div>
            </div>
        </body>
        <script type="text/javascript">
            function logout()
            {
                window.location.href="./logout.php";
            }
        </script>
    </html>