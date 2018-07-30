<?php
defined('_JEXEC') or die('Access Deny');
jimport('joomla.application.component.controller');
class StudentManagementController extends JController
{
	/**
	* Display table
	*/
	function table(){
		$doc=JFactory::getDocument(); 
		$doc->addStyleSheet(JURI::root().'media/com_studentmanagement/css/frontend.css');

		?>
		<details>
		<summary class = "collapsible">Search</summary>
			<form action=index.php/component/studentmanagement/?task=table method="post">
				<div class="inputform">
					<label>Email</label><br>
					<input type="text" class="inputBox" name="searchEmail"><br><br>

					<label>Program</label><br>
					<input type="text" class="inputBox" name="searchProg"><br><br>

					<label>Class</label><br>
					<input type="text" class="inputBox" name="searchClass"><br>

					<label>End Date</label><br>
					<input type="text" class="inputBox" name="searchEnd" placeholder="YYYY-MM-DD"><br><br>

					<input type="submit" name="search" class="btn" value="Search"><br><br>
					<input type="submit" name="reset" class="btn" value="Reset">
				</div>
			</form>
		</details>
		<br>
		<div id="maintable">

			<table>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Program</th>
					<th>Class</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Student ID</th>
					<th>QQ</th>
					<th>Country</th>
					<th>Invoice Number</th>
					<th>Transaction ID</th>
					<th>Payment Date</th>
					<th>Payment Method</th>
					<th>Currency</th>
					<th>Gross Mount</th>
					<th>Fee</th>
					<th>Net</th>
					<th>HST</th>
					<th>Discount</th>
					<th>Misc1</th>
					<th>Misc2</th>
					<th>Misc3</th>
					<th>Misc4</th>
					<th>Misc5</th>
					<th id="fill"></th>
				</tr>

			</table>

			<?php
			
			$db = JFactory::getDBO();

			if (!isset($_GET['startRow']) or !is_numeric($_GET['startRow'])) {
				//we give the value of the starting row to 0 because nothing was found in URL
				$startRow = 0;
				//otherwise we take the value from the URL
			} else {
				$startRow = (int)$_GET['startRow'];
			}


			$query = "SELECT * FROM  #__student_management";

			// logic for search function

			if(isset($_POST['search'])) {
				$email = $_POST['searchEmail'];
				$program = $_POST['searchProg'];
				$endDate = $_POST['searchEnd'];
				$class = $_POST['searchClass'];

				$first = true;
			
				if ($email && !empty($email)) {
					$query .= " WHERE ";
					$query .= "email LIKE'%$email%'";
					$first = false;
				}


				if ($endDate && !empty($endDate)) {
					if ($first) {
						$query .= " WHERE ";
					}
					else {
						$query .= " AND ";
					}
					$query .= "end_date LIKE '%$endDate%'";
					$first = false;
				}

				if ($program && !empty($program)) {
					if ($first) {
						$query .= " WHERE ";
					}
					else {
						$query .= " AND ";
					}
					$query .= "program LIKE '%$program%'";
					$first = false;
				}

				if ($class && !empty($class)) {
					if ($first) {
						$query .= " WHERE ";
					}
					else {
						$query .= " AND ";
					}
					$query .= "class LIKE '%$class%'";
					$first = false;
				}
		
			}

			$query .= " LIMIT $startRow, 20";

			if(isset($_POST['reset'])) {
				$query = "SELECT * FROM  #__student_management";
			}

			$db->setQuery($query);
			$db->execute();
			$rows = $db->loadObjectList();
			$numRows = count($rows);

			if (empty($rows)) {
				echo  "<div class=\"msg\">No results were found</div>";
			} else {
				foreach ($rows as $row) {
				echo "<table>";
				echo "<form action=index.php/component/studentmanagement/?task=update method='post'>";
				echo "<tr>";
				echo '<td><input type="text" name="fullName" class="inputBox" value="'.htmlspecialchars($row->name).'"></td>';
				echo '<td><input type="text" name="email" class="inputBox" value="'.htmlspecialchars($row->email).'"></td>';
				echo '<td><input type="text" name="prog" class="inputBox" value="'.htmlspecialchars($row->program).'"></td>';
				echo '<td><input type="text" name="class" class="inputBox" value="'.htmlspecialchars($row->class).'"></td>';
				echo '<td><input type="text" name="sdate" class="inputBox" value="'.htmlspecialchars($row->start_date).'"></td>';
				echo '<td><input type="text" name="edate" class="inputBox" value="'.htmlspecialchars($row->end_date).'"></td>';
				echo '<td><input type="text" name="stdid" class="inputBox" value="'.htmlspecialchars($row->student_id).'"></td>';
				echo '<td><input type="text" name="qq" class="inputBox" value="'.htmlspecialchars($row->QQ).'"></td>';
				echo '<td><input type="text" name="country" class="inputBox" value="'.htmlspecialchars($row->country).'"></td>';
				echo '<td><input type="text" name="invoice" class="inputBox" value="'.htmlspecialchars($row->invoice_number).'"></td>';
				echo '<td><input type="text" name="transid" class="inputBox" value="'.htmlspecialchars($row->transaction_id).'"></td>';
				echo '<td><input type="text" name="paymentDate" class="inputBox" value="'.htmlspecialchars($row->payment_date).'"></td>';
				echo '<td><input type="text" name="paymentMeth" class="inputBox" value="'.htmlspecialchars($row->payment_method).'"></td>';
				echo '<td><input type="text" name="currency" class="inputBox" value="'.htmlspecialchars($row->currency).'"></td>';
				echo '<td><input type="text" name="grossMount" class="inputBox" value="'.htmlspecialchars($row->gross_mount).'"></td>';
				echo '<td><input type="text" name="fee" class="inputBox" value="'.htmlspecialchars($row->fee).'"></td>';
				echo '<td><input type="text" name="net" class="inputBox" value="'.htmlspecialchars($row->net).'"></td>';
				echo '<td><input type="text" name="hst" class="inputBox" value="'.htmlspecialchars($row->hst).'"></td>';
				echo '<td><input type="text" name="discount" class="inputBox" value="'.htmlspecialchars($row->discount).'"></td>';
				echo '<td><input type="text" name="misc1" class="inputBox" value="'.htmlspecialchars($row->misc1).'"></td>';
				echo '<td><input type="text" name="misc2" class="inputBox" value="'.htmlspecialchars($row->misc2).'"></td>';
				echo '<td><input type="text" name="misc3" class="inputBox" value="'.htmlspecialchars($row->misc3).'"></td>';
				echo '<td><input type="text" name="misc4" class="inputBox" value="'.htmlspecialchars($row->misc4).'"></td>';
				echo '<td><input type="text" name="misc5" class="inputBox" value="'.htmlspecialchars($row->misc5).'"></td>';
				echo "<td class = 'headcol'> <input type=submit name=update class='btn' value=update> 
				<input type=submit name=delete value=delete class='btn'> </td>";
				echo '<td><input type="hidden" name="hidden" value="'.htmlspecialchars($row->email).'"></td>';
				echo "</tr>";
				echo "</form>";
				echo "</table>";
				}	
			}
			

			?>

			<?php
			$prev = $startRow - 20;

			//only print a "Previous" link if a "Next" was clicked
			if ($prev >= 0) {
				echo '<a class="pagination" href="'.$_SERVER['PHP_SELF'].'?task=table&startRow='.$prev.'">Previous</a>';
			}

			if ($numRows >= 20) {
				echo '<a class="pagination" href="'.$_SERVER['PHP_SELF'].'?task=table&startRow='.($startRow+20).'">Next</a>';
			}
			?>

		</div>

		<br>

		<details>
			<summary class = "collapsible">Insert</summary>
			<form action="index.php/component/studentmanagement/?task=insert" method="post">
				<div class="inputform">
					<label>Name</label><br>
					<input type="text" class="inputBox" id="insertName" name="insertName"><br><br>

					<label>Email</label><br>
					<input type="text" class="inputBox" id="insertEmail" name="insertEmail"><br><br>

					<label>Program</label><br>
					<input type="text" class="inputBox" id="insertProgram" name="insertProgram"><br><br>

					<label>Class</label><br>
					<input type="text" class="inputBox" id="insertClass" name="insertClass"><br><br>

					<label>Start Date</label><br>
					<input type="text"  class="inputBox" id="insertStart" name="insertStart" placeholder="YYYY-MM-DD"><br><br>

					<label>End Date</label><br>
					<input type="text" class="inputBox" id="insertEnd" name="insertEnd" placeholder="YYYY-MM-DD"><br><br>

					<label>Student ID</label><br> 
					<input type="number" class="inputBox" id="insertStudentid" name="insertStudentid"><br><br>

					<label>QQ</label><br>
					</Q><input type="text" class="inputBox" id="insertQQ" name="insertQQ"><br><br>

					<label>Country</label><br>
					<input type="text" class="inputBox" id="insertCountry" name="insertCountry"><br><br>
					
					<label>Invoice Number</label><br>
					<input type="text" class="inputBox" id="insertInvoice" name="insertInvoice"><br>

					<label>Transaction ID</label><br>
					<input type="text" class="inputBox" id="insertTransaction" name="insertTransaction"><br><br>

					<label>Payment Date</label><br>
					<input type="text" class="inputBox" id="insertPaymentDate" name="insertPaymentDate"><br><br>

					<label>Payment Method</label><br>
					<input type="text" class="inputBox" id="insertPaymentMethod" name="insertPaymentMethod"><br><br>

					<label>Currency</label><br>
					<input type="text" class="inputBox" id="insertCurrency" name="insertCurrency"><br><br>

					<label>Gross Mount</label><br>
					<input type="text" class="inputBox" id="insertGrossMount" name="insertGrossMount"><br><br>

					<label>Fee</label><br>
					<input type="text" class="inputBox" id="insertFee" name="insertFee"><br><br>

					<label>Net</label><br>
					<input type="text" class="inputBox" id="insertNet" name="insertNet"><br><br>

					<label>HST</label><br>
					<input type="text" class="inputBox" id="insertHst" name="insertHst"><br><br>

					<label>Discount</label><br>
					<input type="text" class="inputBox" id="insertDiscount" name="insertDiscount"><br><br>            
					<input type="submit" name="insert" class="btn" value="submit">
				</div>
			</form>
		</details>
		<br>
		<form action=index.php/component/studentmanagement/?task=export method="post">
			<input type="submit" name="export" class="btn" value="CSV Export" />
		</form>

		</body>
		</html>

		<br>
		<br>
		<form method="post" action="index.php/component/studentmanagement/?task=import" enctype="multipart/form-data">
			<input type="file" name="file" />
			<input type ="submit" class="btn" name="import" value="Import">
		</form>

		<?php
	}

	/**
	* Updates value in table
	*/
	function update(){
		$db = JFactory::getDBO();

		if(isset($_POST['update'])) {
			$query = "UPDATE #__student_management SET name = '$_POST[fullName]',  email = '$_POST[email]', 
			program='$_POST[prog]', class='$_POST[class]', start_date='$_POST[sdate]', end_date='$_POST[edate]', 
			student_id='$_POST[stdid]', QQ='$_POST[qq]', country='$_POST[country]', invoice_number='$_POST[invoice]', 
			transaction_id='$_POST[transid]', payment_date='$_POST[paymentDate]', payment_method='$_POST[paymentMeth]', 
			currency='$_POST[currency]', gross_mount='$_POST[grossMount]', fee='$_POST[fee]', net='$_POST[net]', 
			hst='$_POST[hst]', discount='$_POST[discount]' WHERE email='$_POST[hidden]'";

			$db->setQuery($query);
			$db->query();

			echo "Updating";
		}
		if(isset($_POST['delete'])) {
			$query = "DELETE FROM #__student_management WHERE email='$_POST[hidden]'";

			$db->setQuery($query);
			$db->query();

			echo "Deleting";
		}

		header("refresh:1; url=index.php/component/studentmanagement/?task=table");
	}

	/**
	* Inserts value in table
	*/
	function insert(){
		if (isset($_POST['insert'])) {
			$db = JFactory::getDBO();

			$name = $_POST['insertName'];
			$email = $_POST['insertEmail'];
			$program = $_POST['insertProgram'];
			$class = $_POST['insertClass'];
			$startDate = $_POST['insertStart'];
			$endDate = $_POST['insertEnd'];
			$stid = $_POST['insertStudentid'];
			$QQ = $_POST['insertQQ'];
			$country = $_POST['insertCountry'];
			$invoice = $_POST['insertInvoice'];
			$transaction = $_POST['insertTransaction'];
			$paymentDate = $_POST['insertPaymentDate'];
			$paymentMethod = $_POST['insertPaymentMethod'];
			$currency = $_POST['insertCurrency'];
			$gross = $_POST['insertGrossMount'];
			$fee = $_POST['insertFee'];
			$net = $_POST['insertNet'];
			$hst = $_POST['insertHst'];
			$discount = $_POST['insertDiscount'];

			$query = "INSERT into #__student_management (name, email, program, class, start_date, end_date,
			student_id, QQ, country, invoice_number, transaction_id, payment_date, payment_method, currency,
			gross_mount, fee, net, hst, discount) 
			VALUES ('$name', '$email', '$program', '$class', '$startDate', '$endDate', '$stid', '$QQ', '$country',
			'$invoice', '$transaction', '$paymentDate', '$paymentMethod', '$currency', '$gross', '$fee', '$net', 
			'$hst', '$discount')";

			$db->setQuery($query);
			$db->query();

			echo "Inserting";

			header("refresh:1; url=index.php/component/studentmanagement/?task=table");

		}
	}

	function export(){
	if (isset($_POST['export'])) {

		$db = JFactory::getDBO();
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		$output = fopen("php://output", "w");
		fputcsv($output, array('Name', 'Email', 'Program', 'Class', 'Start Date', 'End Date',
			'Student ID', 'QQ', 'Country', 'Invoice Number', 'Transaction ID', 'Payment Date', 
			'Payment Method', 'Currency', 'Currency', 'Gross Mount', 'Fee', 'Net', 'HST', 'Discount'));

		$query = "SELECT * FROM  #__student_management";
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach ($rows as $row) {
			$array = json_decode(json_encode($row), True);
			fputcsv($output, $array);
		}
		
		fclose($output);

		JFactory::getApplication()->close();

		}	
	}

	function import() {

		if (isset($_POST['import'])) {
			$db = JFactory::getDBO();

			$file = $_FILES['file']['tmp_name'];

			$handle = fopen($file, "r");

			while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {

				$name = $fileop[0];
				$email = $fileop[1];
				$program = $fileop[2];
				$class = $fileop[3];
				$startDate = $fileop[4];
				$endDate = $fileop[5];
				$stid = $fileop[6];
				$QQ = $fileop[7];
				$country = $fileop[8];
				$invoice = $fileop[9];
				$transaction = $fileop[10];
				$paymentDate = $fileop[11];
				$paymentMethod = $fileop[12];
				$currency = $fileop[13];
				$gross = $fileop[14];
				$fee = $fileop[15];
				$net = $fileop[16];
				$hst = $fileop[17];
				$discount = $fileop[18];

				$query = "INSERT into #__student_management (name, email, program, class, start_date, end_date,
				student_id, QQ, country, invoice_number, transaction_id, payment_date, payment_method, currency,
				gross_mount, fee, net, hst, discount) 
				VALUES ('$name', '$email', '$program', '$class', '$startDate', '$endDate', '$stid', '$QQ', '$country',
				'$invoice', '$transaction', '$paymentDate', '$paymentMethod', '$currency', '$gross', '$fee', '$net', 
				'$hst', '$discount')";

				$db->setQuery($query);
				$db->query();
			}

			echo "Importing";
		}
		header("refresh:1; url=index.php/component/studentmanagement/?task=table");
	}
}