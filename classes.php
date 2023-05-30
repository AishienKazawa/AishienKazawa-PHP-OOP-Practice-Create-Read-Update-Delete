<?php

class Emp_management
{

    // initialize private properties 
    private $db_server = "localhost";
    private $db_user = "root";
    private $db_pass = "";
    private $db_name = "emplyee_management";
    protected $conn;

    // connection to the database
    public function openConn()
    {

        try {

            $this->conn = mysqli_connect(
                $this->db_server,
                $this->db_user,
                $this->db_pass,
                $this->db_name
            );

            // if the connection fails
            if (!$this->conn) {
                throw new Exception("Could not connect to the database!");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // close connection to the database
    public function closeConn()
    {

        if (!isset($_SESSION)) {
            session_start();
        }

        // clearing any user data stored in the session
        $_SESSION["userdata"] = null;

        // removes the "userdata" key from the $_SESSION
        unset($_SESSION["userdata"]);

        // close the database
        $this->conn = null;
    }

    // sign in
    public function signIn()
    {

        // establish a connection to the database before executing the SQL query
        $this->openConn();

        // superglobal variable is used to retrieve the values submitted via a form with the HTTP POST method
        $adminID = $_POST["adminId"];
        $password = $_POST["password"];

        // check if the values are empty
        if (empty($adminID) || empty($password)) {

            return "Please fill in all fields.";
        }

        // sql query
        $sql = "SELECT * FROM admin_accounts WHERE admin_id = ?";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);
        // bind the params in sql statement
        mysqli_stmt_bind_param($stmt, "s", $adminID);
        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);

        // retrieve result, convert into object that can be iterated
        $result = mysqli_stmt_get_result($stmt);

        // fetch the row from the result return as associative array and assigned to $row
        if ($row = mysqli_fetch_assoc($result)) {
            // get the password based on the row data
            $currentPassword = $row["password"];

            if (password_verify($password, $currentPassword)) {

                $this->setUserdata($row);
                header("Location: dashboard.php");
            } else {
                return "Invalid credentials";
            }
        } else {
            return "Check you email or password!";
        }
    }

    // check if there's no session userdata
    public function checkCredentials()
    {

        // return if there's a session data or null
        $userdata = $this->getUserdata();

        // check if null
        if (!$userdata) {
            header("Location: index.php");
            exit();
        }
    }

    // set and get session data
    public function setUserdata($row)
    {

        if (!isset($_SESSION)) {
            session_start();
        }

        // store the row data in SESSION array
        $_SESSION["userdata"] = array("first_name" => $row["first_name"], "last_name" => $row["last_name"]);

        return $_SESSION["userdata"];
    }

    public function getUserdata()
    {

        session_start();

        // check if the SESSION has value
        if (isset($_SESSION["userdata"])) {

            return $_SESSION["userdata"];
        } else {

            echo "null";
            return null;
        }
    }

    // add employee
    public function addEmployee()
    {

        // establish a connection to the database before executing the SQL query
        $this->openConn();

        // superglobal variable is used to retrieve the values submitted via a form with the HTTP POST method

        //$employee_id = $_POST["employee_id"];
        $employee_id = date("Y") . "-" . rand(100000, 999999);
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $address = $_POST["address"];
        $gender = $_POST["gender"];
        $birthday = $_POST["birthday"];
        $contact = $_POST["contact"];
        $role = $_POST["role"];
        $department = $_POST["department"];

        // check if all fields are empty
        if (
            empty($firstname) || empty($lastname) || empty($address) || $gender == "Gender" ||
            empty($birthday) || empty($contact) || $role == "Role" || $department == "Department"
        ) {
            return "Please fill in all fields.";
        }

        //sql query
        $sql = "INSERT INTO employee_details (`employee_id`, `first_name`, `last_name`, `address`, `gender`, `birthday`, `contact_number`, `role`, `department`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);
        // bind the params in sql statement
        mysqli_stmt_bind_param($stmt, "sssssssss", $employee_id, $firstname, $lastname, $address, $gender, $birthday, $contact, $role, $department);
        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);

        header("Location: dashboard.php");
    }

    // add Role
    public function addRole()
    {

        // establish a connection to the database before executing the SQL query
        $this->openConn();

        // superglobal variable is used to retrieve the values submitted via a form with the HTTP POST method
        $role = $_POST["role"];
        $role_acronym = $_POST["role_acronym"];

        // check if all fields are empty
        if (empty($role) || empty($role_acronym)) {

            return "Please fill the email field";
        }

        //sql query
        $sql = "INSERT INTO role (`role`, `acronym`) VALUES(?, ?)";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);
        // bind the params in sql statement
        mysqli_stmt_bind_param($stmt, "ss", $role, $role_acronym);
        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);

        header("Location: dashboard.php");
    }

    // add Department
    public function addDepartment()
    {

        // establish a connection to the database before executing the SQL query
        $this->openConn();

        // superglobal variable is used to retrieve the values submitted via a form with the HTTP POST method
        $department_id = $_POST["department_id"];
        $department_name = $_POST["department_name"];
        $department_acronym = $_POST["department_acronym"];
        $manager = $_POST["manager"];

        // check if all fields are empty
        if (empty($department_id) || empty($department_name) || empty($department_acronym) || empty($manager)) {

            return "Please fill the email field";
        }

        //sql query
        $sql = "INSERT INTO department (`department_id`, `department_name`, `acronym`, `manager`) VALUES(?, ?, ?, ?)";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);

        // bind the params in sql statement
        mysqli_stmt_bind_param($stmt, "ssss", $department_id, $department_name, $department_acronym, $manager);
        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);

        header("Location: dashboard.php");
    }

    // fetch department
    public function getDepartments()
    {

        // establish a connection to the database before executing the SQL query
        $this->openConn();

        //sql query
        $sql = "SELECT * FROM department";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);
        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);
        // retrieve result, convert into object that can be iterated
        $result = mysqli_stmt_get_result($stmt);
        // fetch all rows as an associative array
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $rows;
    }

    // fetch role
    public function getRoles()
    {

        // establish a connection to the database before executing the SQL query
        $this->openConn();

        //sql query
        $sql = "SELECT * FROM role";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);
        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);
        // retrieve result, convert into object that can be iterated
        $result = mysqli_stmt_get_result($stmt);
        // fetch all rows as an associative array
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $rows;
    }

    //fetch employees
    public function getEmployees()
    {

        // establish a connection to the database before executing the SQL query
        $this->openConn();

        //sql query
        $sql = "SELECT ed.*, ea.email 
        FROM employee_accounts AS ea 
        RIGHT JOIN employee_details AS ed ON ea.employee_id = ed.employee_id";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);

        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);
        // retrieve result, convert into object that can be iterated
        $result = mysqli_stmt_get_result($stmt);
        // fetch all rows as an associative array
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $rows;
    }

    // create account for employees
    public function createEmployeeAccount()
    {

        // establish a connection to the database before executing the SQL query
        $this->openConn();

        // superglobal variable is used to retrieve the values submitted via a form with the HTTP POST method
        $password = password_hash("admin", PASSWORD_DEFAULT);
        $employee_id = $_GET["employee_id"];
        $email = $_POST["email"];

        // check if the email is empty
        if (empty($email)) {
            return "Please fill the email field";
        }

        //sql query
        $sql = "INSERT INTO employee_accounts (`employee_id`, `email`, `password`) VALUES(?, ?, ?)";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);
        // bind the params in sql statement
        mysqli_stmt_bind_param($stmt, "sss", $employee_id, $email, $password);
        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);

        header("Location: dashboard.php");
    }

    // get employee details
    public function getEmployeeDetails()
    {

        // establish a connection to the database before executing the SQL query
        $this->openConn();

        $employee_id = $_GET["employee_id"];

        //sql query
        $sql = "SELECT ed.*, ea.email 
         FROM employee_accounts AS ea 
         RIGHT JOIN employee_details AS ed ON ea.employee_id = ed.employee_id WHERE ed.employee_id = ?";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);


        // bind the params in sql statement
        mysqli_stmt_bind_param($stmt, "s", $employee_id);
        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);
        // retrieve result, convert into object that can be iterated
        $result = mysqli_stmt_get_result($stmt);
        // fetch all rows as an associative array
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $rows;
    }

    // edit employee details
    public function editEmployee()
    {

        // establish a connection to the database before executing the SQL query
        $this->openConn();

        // superglobal variable is used to retrieve the values submitted via a form with the HTTP POST method
        $employee_id = $_GET["employee_id"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $address = $_POST["address"];
        $gender = $_POST["gender"];
        $birthday = $_POST["birthday"];
        $email = $_POST["email"];
        $contact = $_POST["contact"];
        $role = $_POST["role"];
        $department = $_POST["department"];

        // check if all fields are empty
        if (
            empty($firstname) || empty($lastname) || empty($email) || empty($address) || $gender == "Gender" ||
            empty($birthday) || empty($contact) || $role == "Role" || $department == "Department"
        ) {
            return "Please fill in all fields.";
        }

        //sql query
        $sql = "UPDATE employee_accounts AS ea RIGHT JOIN employee_details AS ed ON ea.employee_id = ed.employee_id SET ed.first_name = ?, ed.last_name = ?, ed.address = ?, ed.gender = ?, ed.birthday = ?, ed.contact_number = ?, ed.role = ?, ed.department = ?, ea.email = ? WHERE ed.employee_id = ?";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);


        // bind the params in sql statement
        mysqli_stmt_bind_param($stmt, "ssssssssss", $firstname, $lastname, $address, $gender, $birthday, $contact, $role, $department, $email, $employee_id);
        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);

        header("Location: dashboard.php");
    }

    // delete employee
    public function deleteEmployee()
    {

        $employee_id = $_GET["employee_id"];

        // sql query
        $sql = "DELETE FROM employee_details WHERE employee_id = ?";

        // prepare the sql statement
        $stmt = mysqli_prepare($this->conn, $sql);
        // bind the params in sql statement
        mysqli_stmt_bind_param($stmt, "s", $employee_id);
        // executes the prepared statement with the provided values
        mysqli_stmt_execute($stmt);

        header("Location: dashboard.php");
    }
}

// creating a new instance of the Emp_management
$EM = new Emp_management();
