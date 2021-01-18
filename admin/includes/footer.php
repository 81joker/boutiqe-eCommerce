

<div class="text-center" id="footer">&copy; Copyright2020-2012  Shaunta's Boutique </div>


<script>

function updateSizes(){
    var sizeString = '';
    for (let i = 0; i < 12 ;i++) {
        if (jQuery('#size'+i).val() !='') {
            sizeString += jQuery('#size'+i).val() + ':' + jQuery('#qty' + i).val()+ ',';
        }
        
    }
    jQuery('#sizes').val(sizeString);
}


function get_child_options(selected){
    if (typeof selected === 'undefined') {
        var selected = '';
    }
    var prentID = jQuery('#parent').val();
    var data = {"prentID" : prentID , selected:selected};
    jQuery.ajax({
            url:'/~nehadalaa/php-eCommerce/admin/product/child_categories.php',
            method : "POST",
            type: 'POST',
            data: data,
            success: function(data){
                jQuery('#child').html(data);

            },

            error: function (){
                alert('Something went woring withe the child options');
            }

        });
        // history.pushState({},success,'/~nehadalaa/php-eCommerce/admin/product/child_categories.php')


}

jQuery('select[name="parent"]').change(function(){
    get_child_options();
});

</script>
<script src="js/main.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


</body>
</html>