<?include '_includes/header.php'?>

<?if(!empty($errors)){?>
    <script>
    <?foreach($errors as $error){
        echo 'message(0,"'.$error.'");';
    }?>
    </script>
<?}?>

<?include '_includes/breadcrumbs.php'?>

<?=$content?>

<?if (!empty($popupGlobalMessages)){?>
    <?=$popupGlobalMessages?>
    <script>
        $(function () {
            $('#common_global_messages').modal('show');
        });
    </script>
<?}?>

<?include '_includes/footer.php'?>