<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Approval taker</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
<form method="post" action="approvalTaker.php">
 <div class="library">
 	<div class="input-group">
        <label >OS library link</label>
        <input type="text" name="" />
    </div>
    </div>
    	<div class="input-group">
    <div class="address">
        <label for="data[address][0]">Email Id 1</label>
        <input type="text" name="data[address][0]" id="data[address][0]" />
    </div>
       </div>
       	<div class="input-group">
    <button id="add-address" class= "btn">Add Email Id of approver</button>
    <br />
    </div>
    	<div class="input-group">
    <button id="add-address" class= "btn">Add OS library link</button>
    </div>
    <input type="submit" value="Submit" />
</form>
<script>
$(document).ready(function(){
    $("#add-address").click(function(e){
        e.preventDefault();
        var numberOfAddresses = $("#form1").find("input[name^='data[address]']").length;
        var label = '<label for="data[address][' + numberOfAddresses + ']">Email Id ' + (numberOfAddresses + 1) + '</label> ';
        var input = '<input type="text" name="data[address][' + numberOfAddresses + ']" id="data[address][' + numberOfAddresses + ']" />';
        var removeButton = '<button class="remove-address">Remove</button>';
        var html = "<div class='address'>" + label + input + removeButton + "</div>";
        $("#form1").find("#add-address").before(html);
    });
});

$(document).on("click", ".remove-address",function(e){
    e.preventDefault();
    $(this).parents(".address").remove();
    //update labels
    $("#form1").find("label[for^='data[address]']").each(function(){
        $(this).html("Address " + ($(this).parents('.address').index() + 1));
    });
});
</script>
</body>
</head>
</html>
