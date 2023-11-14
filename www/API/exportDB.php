<?php
// The path to the batch file
$backupScript = 'C:\\xampp\\htdocs\\sala\\db_export.bat';

// Run the batch file
exec($backupScript, $output, $returnVar);

// Check if the backup was successful
if ($returnVar === 0) {
  echo "Database backup successful.";
} else {
  echo "Database backup failed.";
}
?>
