<?php require_once('export.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datatable</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- Datatable Dependency end -->


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>


   <style>
       .alert {
  opacity: 1;
  transition: opacity 0.6s; /* 600ms to fade out */
}
.alert {
  padding: 20px;
  background-color: #f44336; /* Red */
  color: white;
  margin-bottom: 15px;
}
.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}


.closebtn:hover {
  color: black;
}
   </style>
    
</head>
<body>
<div class="container" id="refresh">

<div class="col-md-12">
    <div class="card">

        <div class="card-header">

        <form method='get' action=''>
            Start Date <input type='date' class='dateFilter' name='created_at' value='<?php if(isset($_GET['created_at'])) echo $_GET['created_at']; ?>'>
        
            End Date <input type='date' class='dateFilter' name='updated_at' value='<?php if(isset($_GET['updated_at'])) echo $_GET['updated_at']; ?>'>

            <input type='submit' name='but_search' value='Search'>
        </form>
    <br><br>
        </div>

        <div class="card-body">
<br>
<form action="export.php" method="post">
 <input type='hidden' class='dateFilter' name='created_at' value='<?php if(isset($_GET['created_at'])) echo $_GET['created_at']; ?>'>
 
  <input type='hidden' class='dateFilter' name='updated_at' value='<?php if(isset($_GET['updated_at'])) echo $_GET['updated_at']; ?>'>

<input class="dt-button buttons-excel buttons-html5" type="submit"name="export" value="Export to Excel">
</form>
<br>
<div class="alert" style="display:none;">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  New Record Found!
</div>
<br>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>full_name</th>
                <th>Email</th>
                <th>company_name</th>
                <th>phone_number</th>
                <th>Created Date</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
           <?php
           if(!empty($arr_users)) { ?>
            <?php foreach($arr_users as $user) { ?>

                <tr>
                    <td><?php echo $user['full_name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['company_name']; ?></td>
                    <td><?php echo $user['phone_number']; ?></td>
                    <td><?php echo $user['created_date']; ?></td>
                    <td>
                    <form action="update.php">
                         <input type="hidden" full_name="id" value="<?php echo $user['id']; ?>">
                            <select full_name="select"  onchange="this.form.submit()" id="select">
                            
                            <?php if($user['user'] != '')  { ?>
                            <option value="<?php echo $user['user']; ?>"> <?php echo $user['user']; ?> </option>
                            <?php } else { ?>
                            <option value="">Select</option>
                           
                            <option value="a">a</option>
                            <option value="b">b</option>
                            <option value="c">c</option>
                            <option value="d">d</option>
                            
                            <?php } ?>  
                               
                        </select>

                    </form>
                       

                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
   
        </tbody>

</table>

        </div>

    </div>
</div>

</div>
    <script>
            
            $(document).ready(function() {
                    $('#example').DataTable( {
                        "order": [[ 4, "desc" ]]
                    } );
                } );

    </script>
    <script> 

    var old_count = 0;
    var i = 0;
    setInterval(function(){    
    
    $.ajax({
        type : "POST",
        url : "count.php",
        success : function(data){
            if (data > old_count) { if (i == 0){old_count = data;} 
                else{
                // alert('New Record Found!');
                $('.alert').show();

                old_count = data;
            }
            } i=1;
        }
    });
    },1000);
    </script>

    <script>
        window.setInterval('refresh()', 120000); 

        function refresh() {
            window .location.reload();
        }
    </script>

</body>
</html>
