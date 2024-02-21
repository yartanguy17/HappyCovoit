@extends('layouts.base')
@section('title')
Packages
@endsection
@section('top_includes')
<link rel="stylesheet" href="{{ asset('assets/js/jquery-ui.css')}}">
@endsection
@section('content')
@if (Session::has('flash_message_error'))
                <script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
                <script type="text/javascript">;
                swal("{{ session('flash_message_error') }}", "Merci", "error");
                </script>
                @endif
<?php
if (isset($_GET["type"])) {
    $type = $_GET["type"];
    if ($type==1) {
        ?>
        <section class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li><a href="/">Happy-Travel World</a></li>
                        </ol>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h2>Chauffeur Personnel</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-padding our-vehicles-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="booking-form">
                            <form action="/validate-choice" method="post">
                                <input type="text" class="form-control" value="<?= $type ?>" name="type" hidden>
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Pays de Destination</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input type="text" name="pays_destination" placeholder="Pays de Destination" id="pays_destination_chauffeur" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Ville de destination</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input type="text" name="ville_destination" id="ville_destination_chauffeur" placeholder="Ville de Destination(précision)" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Pays de démarrage</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input type="text" name="pays_demarrage" placeholder="Pays de démarrage" id="pays_demarrage_chauffeur" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Ville de démarrage</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input type="text" name="ville_demarrage" id="ville_demarrage_chauffeur" placeholder="Ville de démarrage(précision)" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Date de départ</label>
                                            <i class="fas fa-calendar"></i>
                                            <input type="date" name="date_demarrage" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Heure de Départ</label>
                                            <i class="fas fa-clock"></i>
                                            <input type="time" name="heure_demarrage" class="form-control" required>
                                        </div>
                                    </div>
                                </div>  
                                <center><button type="submit" class="button button-dark tiny">Chercher</button></center>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="/assets/image.jpg" style="" alt="">
                    </div>
                </div>
            </div>
        </section>
        <?php
    }else{
        ?>
        <section class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li><a href="/">Happy-Travel World</a></li>
                        </ol>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h2>Compagnie de Transport</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-padding our-vehicles-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="booking-form">
                            <form action="/validate-choice" method="post">
                                <input type="text" class="form-control" value="<?= $type ?>" name="type" hidden>
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Pays de Destination</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input type="text" name="pays_destination" placeholder="Pays de Destination" id="pays_destination_compagnie" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Ville de destination</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input type="text" name="ville_destination" id="ville_destination_compagnie" placeholder="Ville de Destination(précision)" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Pays de démarrage</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input type="text" name="pays_demarrage" placeholder="Pays de démarrage" id="pays_demarrage_compagnie" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Ville de démarrage</label>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input type="text" name="ville_demarrage" id="ville_demarrage_compagnie" placeholder="Ville de démarrage(précision)" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Date de départ</label>
                                            <i class="fas fa-calendar"></i>
                                            <input type="date" name="date_demarrage" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="from-group destination">
                                            <label for="">Heure de Départ</label>
                                            <i class="fas fa-clock"></i>
                                            <input type="time" name="heure_demarrage" class="form-control" required>
                                        </div>
                                    </div>
                                </div>  
                                <center><button type="submit" class="button button-dark tiny">Chercher</button></center>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="/assets/image.jpg" style="" alt="">
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}else{
    ?>
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li><a href="/">Happy-Travel World</a></li>
                    </ol>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h2>Choisir le type</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding our-pakages-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <h2 class="section-title text-center">Type</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 col-md-6">

                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-package-item text-center">
                        <div class="package-icon">
                            <span class="icon-wrapper">
                                <img src="/assets/images/icon/package-icon.png" alt="icon">
                            </span>
                        </div>
                        <div class="package-details">
                            <h4 class="section-title text-center">Chauffeur personnel</h4>
                            <a href="/choice?type=1" class="button button-dark tiny find-depart">Choisir</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">

                </div>
                <div class="col-lg-4 offset-lg-0 col-md-6 offset-md-3">
                    <div class="single-package-item text-center">
                        <div class="package-icon">
                            <span class="icon-wrapper">
                                <img src="/assets/images/icon/package-icon.png" alt="icon">
                            </span>
                        </div>
                        <div class="package-details">
                            <h4 class="section-title text-center">Compagnie de Transport</h4>
                            <a href="/choice?type=2" class="button button-dark tiny find-depart">Choisir</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md-6">

                </div>
            </div>
        </div>
    </section>
    <?php
}
?>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/jquery-1.12.4.js')}}"></script>
<script src="{{ asset('assets/js/jquery-ui.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#pays_destination_chauffeur").autocomplete({
            source: "/api/search-pays-destination-chauffeur",
            delay: 100,
            minLength: 2,
        /*search: function( event, ui ) {
          $("#loading").prop("hidden", false);
      },*/
      open: function( event, ui ) {
        var acData = $(this).data('ui-autocomplete');
        acData
        .menu
        .element
        .find('li')
        .each(function () {
            var me = $(this);
            var keywords = acData.term.split(' ').join('|');
            let textWrapper = me.find('.ui-menu-item-wrapper'); 
            let text = textWrapper.text(); 
            let newTextHtml = text.replace(new RegExp("(" + keywords + ")", "gi"), '<b>$1</b>');
            textWrapper.html(newTextHtml);
        });
    },
    select: function( event, ui ) {
      console.log(ui.item);
  }
});
        $("#ville_destination_chauffeur").autocomplete({
            source: "/api/search-ville-destination-chauffeur",
            delay: 100,
            minLength: 2,
        /*search: function( event, ui ) {
          $("#loading").prop("hidden", false);
      },*/
      open: function( event, ui ) {
        var acData = $(this).data('ui-autocomplete');
        acData
        .menu
        .element
        .find('li')
        .each(function () {
            var me = $(this);
            var keywords = acData.term.split(' ').join('|');
            let textWrapper = me.find('.ui-menu-item-wrapper'); 
            let text = textWrapper.text(); 
            let newTextHtml = text.replace(new RegExp("(" + keywords + ")", "gi"), '<b>$1</b>');
            textWrapper.html(newTextHtml);
        });
    },
    select: function( event, ui ) {
      console.log(ui.item);
  }
});
        $("#pays_demarrage_chauffeur").autocomplete({
            source: "/api/search-pays-demarrage-chauffeur",
            delay: 100,
            minLength: 2,
        /*search: function( event, ui ) {
          $("#loading").prop("hidden", false);
      },*/
      open: function( event, ui ) {
        var acData = $(this).data('ui-autocomplete');
        acData
        .menu
        .element
        .find('li')
        .each(function () {
            var me = $(this);
            var keywords = acData.term.split(' ').join('|');
            let textWrapper = me.find('.ui-menu-item-wrapper'); 
            let text = textWrapper.text(); 
            let newTextHtml = text.replace(new RegExp("(" + keywords + ")", "gi"), '<b>$1</b>');
            textWrapper.html(newTextHtml);
        });
    },
    select: function( event, ui ) {
      console.log(ui.item);
  }
});
        $("#ville_demarrage_chauffeur").autocomplete({
            source: "/api/search-ville-demarrage-chauffeur",
            delay: 100,
            minLength: 2,
        /*search: function( event, ui ) {
          $("#loading").prop("hidden", false);
      },*/
      open: function( event, ui ) {
        var acData = $(this).data('ui-autocomplete');
        acData
        .menu
        .element
        .find('li')
        .each(function () {
            var me = $(this);
            var keywords = acData.term.split(' ').join('|');
            let textWrapper = me.find('.ui-menu-item-wrapper'); 
            let text = textWrapper.text(); 
            let newTextHtml = text.replace(new RegExp("(" + keywords + ")", "gi"), '<b>$1</b>');
            textWrapper.html(newTextHtml);
        });
    },
    select: function( event, ui ) {
      console.log(ui.item);
  }
});

        $("#pays_destination_compagnie").autocomplete({
            source: "/api/search-pays-destination-compagnie",
            delay: 100,
            minLength: 2,
        /*search: function( event, ui ) {
          $("#loading").prop("hidden", false);
      },*/
      open: function( event, ui ) {
        var acData = $(this).data('ui-autocomplete');
        acData
        .menu
        .element
        .find('li')
        .each(function () {
            var me = $(this);
            var keywords = acData.term.split(' ').join('|');
            let textWrapper = me.find('.ui-menu-item-wrapper'); 
            let text = textWrapper.text(); 
            let newTextHtml = text.replace(new RegExp("(" + keywords + ")", "gi"), '<b>$1</b>');
            textWrapper.html(newTextHtml);
        });
    },
    select: function( event, ui ) {
      console.log(ui.item);
  }
});
        $("#ville_destination_compagnie").autocomplete({
            source: "/api/search-ville-destination-compagnie",
            delay: 100,
            minLength: 2,
        /*search: function( event, ui ) {
          $("#loading").prop("hidden", false);
      },*/
      open: function( event, ui ) {
        var acData = $(this).data('ui-autocomplete');
        acData
        .menu
        .element
        .find('li')
        .each(function () {
            var me = $(this);
            var keywords = acData.term.split(' ').join('|');
            let textWrapper = me.find('.ui-menu-item-wrapper'); 
            let text = textWrapper.text(); 
            let newTextHtml = text.replace(new RegExp("(" + keywords + ")", "gi"), '<b>$1</b>');
            textWrapper.html(newTextHtml);
        });
    },
    select: function( event, ui ) {
      console.log(ui.item);
  }
});
        $("#pays_demarrage_compagnie").autocomplete({
            source: "/api/search-pays-demarrage-compagnie",
            delay: 100,
            minLength: 2,
        /*search: function( event, ui ) {
          $("#loading").prop("hidden", false);
      },*/
      open: function( event, ui ) {
        var acData = $(this).data('ui-autocomplete');
        acData
        .menu
        .element
        .find('li')
        .each(function () {
            var me = $(this);
            var keywords = acData.term.split(' ').join('|');
            let textWrapper = me.find('.ui-menu-item-wrapper'); 
            let text = textWrapper.text(); 
            let newTextHtml = text.replace(new RegExp("(" + keywords + ")", "gi"), '<b>$1</b>');
            textWrapper.html(newTextHtml);
        });
    },
    select: function( event, ui ) {
      console.log(ui.item);
  }
});
        $("#ville_demarrage_compagnie").autocomplete({
            source: "/api/search-ville-demarrage-compagnie",
            delay: 100,
            minLength: 2,
        /*search: function( event, ui ) {
          $("#loading").prop("hidden", false);
      },*/
      open: function( event, ui ) {
        var acData = $(this).data('ui-autocomplete');
        acData
        .menu
        .element
        .find('li')
        .each(function () {
            var me = $(this);
            var keywords = acData.term.split(' ').join('|');
            let textWrapper = me.find('.ui-menu-item-wrapper'); 
            let text = textWrapper.text(); 
            let newTextHtml = text.replace(new RegExp("(" + keywords + ")", "gi"), '<b>$1</b>');
            textWrapper.html(newTextHtml);
        });
    },
    select: function( event, ui ) {
      console.log(ui.item);
  }
});
    }); 
</script>
@endsection
