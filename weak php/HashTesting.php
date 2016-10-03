<?php
  //string password_hash
      //( string $password , integer $algo [, array $options ] )
      /*
      $password = "Ku1_7ös3n_0rd";
      echo $password;
      $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
      echo "<br>";
      echo $hashedpassword;
      echo "<br><br><br>";
      */

      /*
      $hash1 = password_hash('test', PASSWORD_DEFAULT);
      $hash2 = password_hash('test', PASSWORD_DEFAULT);

      echo "Password is test <br>";
      echo $hash1. "<br>";
      echo $hash2. "<br>";
      if (password_verify('test', $hash1)) {
      echo 'hash1 is valid!';
      } else {
      echo 'Invalid hash1.';
      }
      echo "<br>";
      if (password_verify('test', $hash2)) {
      echo 'hash2 is valid!';
      } else {
      echo 'Invalid hash2.';
      }
      */

      $options = ['salt' => "xxxxxxxxxxxxxxxxxxxyyy"];
      echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options)."\n";
?>
