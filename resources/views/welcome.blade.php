<!DOCTYPE html>
<html lang="en">

@include('lte.htmlhead', ['company' => 'paal'])

<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <b>PAAL</b>
  </div>

  <div class="lockscreen-item">

    <div class="lockscreen-image">
      <img src="{{ asset('/img/paal.png') }}" alt="Paal Admin">
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
      <img src="{{ asset('/img/coffee.png')  }}" alt="Coffee Depot">
    </div>

    <div class="lockscreen-credentials">
      <div class="input-group">
        <input type="text" class="form-control" value="COFFEE" disabled>

        <div class="input-group-btn">
          <a href="/coffee" class="btn"><i class="fa fa-arrow-right text-muted"></i></a>
        </div>
      </div>
    </div>

  </div>

  <br>

  <div class="lockscreen-item">

    <div class="lockscreen-image">
      <img src="{{ asset('/img/mbe.png')  }}" alt="Mailboxes etc">
    </div>

    <div class="lockscreen-credentials">
      <div class="input-group">
        <input type="text" class="form-control" value="MAILBOXES" disabled>

        <div class="input-group-btn">
          <a href="/mbe" class="btn"><i class="fa fa-arrow-right text-muted"></i></a>
        </div>
      </div>
    </div>

  </div>

  <div class="help-block text-center">
    Elija a qué sitio quiere dirigirse
  </div>
</div>
</body>
</html>
