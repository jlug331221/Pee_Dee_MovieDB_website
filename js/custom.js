$( document ).ready(function() {
    
    var add_person_box = null;
    
    $('.adv-table-results').DataTable();
    
    $('#datefield').datepicker({
        format: "yyyy/mm/dd"
    });  
    
    $('[data-toggle="tooltip"]').tooltip();
    
    
   /*$('#runtimemin').on('input', function() {
       //console.log($('#runtimemin').val());
       var valmin = parseInt($('#runtimemin').val());
       var valmax = parseInt($('#runtimemax').val());
       
       if(!Number.isInteger(valmin)) {
           $('#runtime-form-group').addClass('has-error');
       }
   });*/
    
//    $('#add-actor-role').change(function() {
//        if($(this).is(":checked")) {
//            add_person_box = document.createElement('div');
//            add_person_box.setAttribute('class', 'form-group');
//                var label = document.createElement('label');
//                label.setAttribute('class', 'control-label col-sm-2');
//                label.setAttribute('for', 'rolename');
//                label.textContent = 'Role name:';
//                    var div = document.createElement('div');
//                    div.setAttribute('class', 'control-label col-sm-10');
//                        var input = document.createElement('input');
//                        input.setAttribute('type', 'text');
//                        input.setAttribute('class', 'form-control');
//                        input.setAttribute('name', 'rolename');
//                        input.setAttribute('placeholder', 'Enter role name');
//            
//                    div.appendChild(input);
//                label.appendChild(input);
//            add_person_box.appendChild(label);
//            var target = document.querySelector('#actor-target');
//            target.appendChild(add_person_box);
//        }
//        else {
//            var target = document.querySelector('#actor-target');
//            target.removeChild(add_person_box);
//        }        
//    });
//    
});

//<div class="form-group">
    //<label class="control-label col-sm-2" for="first">First:</label>
        //<div class="col-sm-10">
        //  <input type=text class="form-control" name="first" placeholder="Enter First Name">
    //</div>
//</div>







