<?php

// Soo saar dhammaan users
function getAll($conn)
{
   $sql = "SELECT * FROM users ORDER BY id DESC";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   } else {
      return [];
   }
}

// Soo saar user gaar ah by ID
function getUserById($id, $conn)
{
   $sql = "SELECT * FROM users WHERE id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() == 1) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
   } else {
      return false;
   }
}

// Delete user by ID
function deleteById($conn, $id)
{
   $sql = "DELETE FROM users WHERE id=?";
   $stmt = $conn->prepare($sql);
   return $stmt->execute([$id]);
}

// (Optional) Add user
function addUser($conn, $data)
{
   $sql = "INSERT INTO users 
        (fname,lname,username,password,sex,phone,email,profile_picture,role,user_status)
        VALUES (?,?,?,?,?,?,?,?,?,?)";

   $stmt = $conn->prepare($sql);
   return $stmt->execute([
      $data['fname'],
      $data['lname'],
      $data['username'],
      $data['password'],
      $data['sex'],
      $data['phone'],
      $data['email'],
      $data['profile_picture'],
      $data['role'],
      $data['user_status']
   ]);
}

// (Optional) Update user
function updateUser($conn, $data)
{
   $sql = "UPDATE users SET 
        fname=?, lname=?, username=?, password=?,
        sex=?, phone=?, email=?, profile_picture=?,
        role=?, user_status=?
        WHERE id=?";

   $stmt = $conn->prepare($sql);
   return $stmt->execute([
      $data['fname'],
      $data['lname'],
      $data['username'],
      $data['password'],
      $data['sex'],
      $data['phone'],
      $data['email'],
      $data['profile_picture'],
      $data['role'],
      $data['user_status'],
      $data['id']
   ]);
}
