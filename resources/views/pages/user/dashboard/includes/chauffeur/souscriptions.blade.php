<div role="tabpanel" class="tab-pane" id="souscriptions">
  <div class="rides-details">
    <div class="row">
      <div class="col-lg-6">
        <h4>Souscriptions</h4>
      </div>
    </div>

    <div class="row small-section">
      <div class="col-lg-12">
        <div class="total-earning-table table-responsive">
          <table class="table">
           <thead>
            <tr>
              <th scope="col">Date souscription</th>
              <th scope="col">Validité</th>
              <th scope="col">État</th>
            </tr>
          </thead>
          <tbody>
           @foreach($souscriptions as $souscription)
           <tr>
            <td>{{ $souscription->date_souscription }}</td>
            <td><b>{{ $souscription->validite }}</b></td>
            <td>
              <?php
              if($souscription->paiements->count() > 0){
              if($souscription->paiements[0]['type'] == 1){
               if (checkPayment($souscription->paiements[0]['identifier']) == 0) {
                 ?>
                 <a class="btn btn-success" style="color: white"> Déjà Payé</a>
                 <?php
               }else{
                $urlPaiement = 'https://paygateglobal.com/v1/page?token=8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4&amount=' . $souscription->paiements[0]['amount']  . '&description=Souscription&identifier='. $souscription->paiements[0]['identifier'];
                ?>
                <b style="color: black">Non Payé</b>&nbsp;&nbsp;
            <a onclick="payNow('{{ $souscription->id }}')" class="btn btn-warning" style="color:white;">Payer maintenant
            </a>
            <?php
          }
        }else{
          if ($souscription->paiements[0]['status'] == 1) {
           ?>
           <a class="btn btn-success" style="color: white"> Déjà Payé</a>
           <?php
         }else{
          ?>
          <b style="color: black">Non Payé</b>
          &nbsp;&nbsp;
          <a onclick="payNow('{{ $souscription->id }}')" class="btn btn-warning" style="color:white;">Payer maintenant
            </a>
      <?php
    }
  }}else{
     ?>
          <b style="color: black">Non Payé</b>
          &nbsp;&nbsp;
          <a onclick="payNow('{{ $souscription->id }}')" class="btn btn-warning" style="color:white;">Payer maintenant
            </a>
      <?php
  }
  ?>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>