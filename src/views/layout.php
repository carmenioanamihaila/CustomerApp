
<DOCTYPE html>
<html>
  <head>
  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <script>
    function showfields(id) {
        for(i=1; i<=3; i++)
        {
            idElement = "ct_" + i;
            divElement = "div_" + i;
            if (i != id) {
                $('#' + idElement).css("background", "#E0FFFF");
                $('#' + divElement).hide();
            } else {
                $('#' + idElement).css("background", "#008B8B");
                $('#' + divElement).show();
            }
        }
        $("input[id=customertype]").val(id);
    }
  </script>
  <link rel="stylesheet" type="text/css" href="css/general.css">
  </head>
  <body>
      <form id="addForm" action="index.php?controller=customer&action=add" method="post">
        <div class="left">
            <input type="hidden" name="customertype" id="customertype" value="1"/>
            <b>New customer</b><br>
            <b>Services</b><br>
            <?php foreach($services as $service) { ?>
            <input type="radio" name="service" value="<?php echo $service->id; ?>" <?php if($service->id == 1) {echo "checked";}?>> <?php echo $service->name;?><br>
            <?php } 
            foreach($customertypes as $ct) { ?>
               <p class="buttonstype" id="ct_<?php echo $ct->id;?>" onclick="showfields(<?php echo $ct->id;?>);"> <?php echo $ct->type;?></p>
            <?php } ?><br><br><br><br></br>
            <!--This div is for Citizen fields-->
            <div id="div_1">
                Title:<select id='title' name='title'>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Miss">Miss</option>
                </select><br>
                First name:<input type='text' id='firstname' name='firstname'/><br>
                Last name:<input type='text' id='lastname' name='lastname'/><br>
            </div>
            <!--This div is for Organization fields-->
            <div id="div_2" hidden>
                Name: <input type='text' id='organizationname' name='organizationname'/><br>
            </div>
            <input type='submit' value="Submit"/>
        </div>
        <div class="right">
            <b>Queue</b></br>
            <table border="1">
                <th>Type</th>
                <th>Name</th>
                <th>Service</th>
                <th>Queued at</th>
                <?php foreach ($customers as $customer) { ?>
                <tr>
                    <td>
                        <?php echo $customer->getCustomerType();?>
                    </td>
                    <td>
                        <?php echo $customer->getName();?>
                    </td>
                    <td>
                        <?php echo $customer->getServiceName();?>
                    </td>
                    <td>
                        <?php echo $customer->getQueueTime();?>
                    </td>
                </tr>
                <?php } ?>
                <tr></tr>
            </table>
        </div>
    </form>
  <body>
  <script>
    $('#ct_1').css( "background-color", "#008B8B");
    $( "#addForm" ).submit(function( event ) {
        var $list = $("#addForm :input[type='text']");

        $list.each(function(){
            var $currentItem = $(this);
            if ($currentItem.is(":visible") && !$currentItem.val() ) {
                alert( "You want to submit an empty value!" );
                event.preventDefault();
                exit;
            }; 
        });
    });
  </script>
<html>


