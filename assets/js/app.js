/**
 * Created by ESGRA on 13/03/2017.
 */
$(function(){

    "use-strict"
    $('input, a, button').tooltip();
    $('#phone_number').change(function(e){
        $('#__n').text($(e.target).val());
    });

    $("#items-select").multiselect({
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Recherche le vendeur',
        enableHTML: true,
        onChange: function(option, checked, selected){
            //alert(baseURL+'usernumbers/'+option.val());

            if(option.val() != 0) {
                $.ajax({
                    type: 'get',
                    url: baseURL + 'usernumbers/' + array_keyer(option.val()),
                    dataType: 'json',
                    success: function (data) {
                        option.addClass('current');
                        tableIt('#numbers_list', data);
                    }
                });
            }
        }
    });

    $(document).ajaxStart(function(){
        $('#ajax-notif').html('Chargement des données...');
        $('.content').css({
            opacity:'0.2',
            cursor: 'wait'
        });
        $('#ajax-notif').show();
    })
    $(document).ajaxComplete(function(){
        $('#ajax-notif').html('');
        $('.content').css({
            opacity:'1',
            cursor: 'auto'
        });
        $('#ajax-notif').hide();
    })

    function tableIt(element, data)
    {
        $(element).html('');
        datas = '<table class="table table-bordered">';
        if(typeof data == 'boolean')
        {
            datas = '<div class="alert alert-warning">Pas de numéro pour ce vendeur</div>';
        }else {
            for (el in data) {
                datas += '<tr><th>' + data[el]['nom'] + '</th><td>' + data[el]['number'] + '</td></tr>';
            }
            datas += '</table>';
        }

        $(element).html(datas);
    }

    function array_keyer(string)
    {
        return string.replace("/(\.){1}(.{2,5})$/i", '_$1');
    }

    /**
     * L'envoie de numéro de téléphone via ajax à la page user/commande
     */

    //$("items-select").on('change',function(e){
    //    alert(e.target);
    //})
});