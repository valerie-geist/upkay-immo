$(document).ready(function () {

// JS AFFICHAGE DONNEES FORMULAIRE DYNAMIQUE (Changement de la case catégorie en fonction de l'intervention choisie)

    let $prestation_intervention = $("#prestation_intervention");
    let $token = $("#prestation_token");

    $prestation_intervention.change(function () {
        let $form = $(this).closest('form');
        let data = {};

        data[$token.attr('name')] = $token.val();
        data[$prestation_intervention.attr('name')] = $prestation_intervention.val();

        $.post($form.attr('action'), data).then(function (response) {
            $('#prestation_categorie').replaceWith(
                $(response).find('#prestation_categorie')
            )
        })
    });

});
