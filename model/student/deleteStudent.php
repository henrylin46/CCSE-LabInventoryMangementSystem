<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['studentDetailsStudentMatricNumber'])){
		
		$studentDetailsStudentMatricNumber = htmlentities($_POST['studentDetailsStudentMatricNumber']);
		
		// Check if mandatory fields are not empty
		if(!empty($studentDetailsStudentMatricNumber)){
			
			// Sanitize studentID
            $studentDetailsStudentMatricNumber = filter_var($studentDetailsStudentMatricNumber, FILTER_SANITIZE_STRING);

			// Check if the student is in the database
			$studentSql = 'SELECT studentID FROM student WHERE matricNumber=:matricNumber';
			$studentStatement = $conn->prepare($studentSql);
			$studentStatement->execute(['matricNumber' => $studentDetailsStudentMatricNumber]);
			
			if($studentStatement->rowCount() > 0){
				
				// Student exists in DB. Hence start the DELETE process
				$deleteStudentSql = 'DELETE FROM student WHERE matricNumber=:matricNumber';
				$deleteStudentStatement = $conn->prepare($deleteStudentSql);
				$deleteStudentStatement->execute(['matricNumber' => $studentDetailsStudentMatricNumber]);

				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Student deleted.</div>';
				exit();
				
			} else {
				// Student does not exist, therefore, tell the user that he can't delete that student
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Student does not exist in DB. Therefore, can\'t delete.</div>';
				exit();
			}
			
		} else {
			// StudentID is empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter the StudentID</div>';
			exit();
		}
	}
?>