<!DOCTYPE html>
<html>

@include('lte.htmlhead', ['company' => '/paal'])

<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <b>PAAL</b>
  </div>

  <div class="lockscreen-item">

    <div class="lockscreen-image">
      <img src="{{ asset('/img/paal.jpg') }}" alt="Paal Admin">
    </div>

    <div class="lockscreen-credentials">
      <div class="input-group">
        <input type="text" class="form-control" value="ADMIN" disabled>

        <div class="input-group-btn">
          <a href="/paal" class="btn"><i class="fa fa-arrow-right text-muted"></i></a>
        </div>
      </div>
    </div>

  </div>

  <br>

  <div class="lockscreen-item">

    <div class="lockscreen-image">
      <img src="{{ asset('/img/cocinas_paal_icon.jpg')  }}" alt="Cocinas Paal">
    </div>

    <div class="lockscreen-credentials">
      <div class="input-group">
        <input type="text" class="form-control" value="COCINASPAAL" disabled>

        <div class="input-group-btn">
          <a href="/cocinaspaal" class="btn"><i class="fa fa-arrow-right text-muted"></i></a>
        </div>
      </div>
    </div>

  </div>


  <br>

  <div class="lockscreen-item">

    <div class="lockscreen-image">
      <img src="{{ asset('/img/logistica_paal_icon.png')  }}" alt="mbe">
    </div>

    <div class="lockscreen-credentials">
      <div class="input-group">
        <input type="text" class="form-control" value="LOGÍSTICAPAAL" disabled>

        <div class="input-group-btn">
          <a href="/mbe" class="btn"><i class="fa fa-arrow-right text-muted"></i></a>
        </div>
      </div>
    </div>

  </div>

  <br>

  {{-- <div class="lockscreen-item">

    <div class="lockscreen-image">
      <img src="{{ asset('/img/sanson_login.png')  }}" alt="San - Son">
    </div>

    <div class="lockscreen-credentials">
      <div class="input-group">
        <input type="text" class="form-control" value="SAN-SON" disabled>

        <div class="input-group-btn">
          <a href="/sanson" class="btn"><i class="fa fa-arrow-right text-muted"></i></a>
        </div>
      </div>
    </div>

  </div> --}}
  
  <div class="help-block text-center">
    Elija a qué sitio quiere dirigirse
  </div>
</div>
</body>
</html>
