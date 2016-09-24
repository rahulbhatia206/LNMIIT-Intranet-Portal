<?php
	require('../header.php');
	require('sidebar.php');
?>

<div class="main-content">
        <div id="contents">
        <h1 class="body_title">Hostel</h1>
        <div class="links">
            <ul>
                <li><a href="pdf/hostel_rules.pdf" target="__self">Hostel Rules and Code of Conduct</a></li><br>
                <li><a href="student_info.php" target="_self">Student Information</a></li><br>
                <li><a href="leave_application.php" target="_self">Leave Application</a></li><br>
                <?php
                    if(isset($_SESSION['admin']) and ((@$_SESSION['admin']==3) || (@$_SESSION['admin']==6)))
                    {
                        echo "<li><a href='approve.php' target='_self'>Approve Leave Application</a></li><br>";
                    }
                ?>





            </ul>
        </div>



	
	</div>


   
</div>
<?php
	require('../footer.php');
?>