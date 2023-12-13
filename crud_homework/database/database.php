<?php

/**
 * Connect to database
 */

function db()
{
    $host     = 'localhost';
    $database = 'web_a';
    $user     = 'root';
    $password = '';
    try {
        $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        // set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $db = null;
}
/**
 * Create new student record
 */
function createStudent($value)
{
    $conn = db();

    $name = $value['name'];
    $age = $value['age'];
    $email = $value['email'];
    $profile = $value['profile'];

    try {
        $sql = "INSERT INTO student (name, age, email, profile) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $age, $email, $profile]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $db = null;
}

/**
 * Get all data from table student
 */
function selectAllStudents()
{
    $conn = db();

    try {
        $sql = "SELECT * FROM student";
        $stmt = $conn->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $db = null;
}

/**
 * Get only one on record by id 
 */
function selectOnestudent($id)
{
    $conn = db();

    try {
        $sql = "SELECT * FROM student WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $db = null;
}

/**
 * Delete student by id
 */
function deleteStudent($id)
{
    $conn = db();

    try {
        $sql = "DELETE FROM student WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        echo "Error deleting student: " . $e->getMessage();
    }
    $db = null;
}


/**
 * Update students
 * 
 */
function updateStudent($id, $data)
{
    $db = db();

    try {
        $sql = "UPDATE student SET ";
        $placeholders = [];

        foreach ($data as $column => $value) {
            $sql .= "$column = ?, ";
            $placeholders[] = $value;
        }

        $sql = rtrim($sql, ", ") . " WHERE id = ?";
        $placeholders[] = $id;

        $stmt = $db->prepare($sql);
        $stmt->execute($placeholders);
    } catch (PDOException $e) {
        echo "Error updating student: " . $e->getMessage();
    }

    $db = null;
}
