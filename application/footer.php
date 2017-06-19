    <footer>
        <!--defining scripts location and css styles locations--> 
        <script type="text/javascript" src="js/myscripts.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!--script for date picker-->
        <script>
            $( function() {
                $( "#datefrom" ).datepicker();
                $( "#dateto" ).datepicker();
            } );
        </script>
        <div id="media">
            <!--display icons for social media linked to developer's account-->
            <a href="https://www.facebook.com/vladimir.vustean" target="_blank"><img class="media_icon" src="/application/images/facebook.png"></a>
            <a href="https://www.youtube.com/channel/UCc3Pwy9YbpnEZyKlZVTc_Hg" target="_blank"><img class="media_icon" src="/application/images/youtube.png"></a>
            <a href=""><img class="media_icon" src="/application/images/twitter.png" target="_blank"></a>
        </div>
        <center>
            <a class="contact" href="mailto:vladimir.vustean@student.griffith.ie">Vladimir Vustean</a>
            <a>
                <!--if username is admin, display link to admin page-->
                <?php if($_SESSION['username'] == 'admin')
                echo "<a class='contact' href='admin.php'> -Admin-</a>";
                ?>
            </a>
        </center>
    </footer>
</body>
</html>