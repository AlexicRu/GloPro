<?include '_includes/header.php'?>

<?if(!empty($errors)){?>
    <script>
    <?foreach($errors as $error){
        echo 'message(0,"'.$error.'");';
    }?>
    </script>
<?}?>
<?=$content?>

<?include '_includes/footer.php'?>