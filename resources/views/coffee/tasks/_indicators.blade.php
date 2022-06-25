<div class="btn-group">
  
  <button type="button" class="btn {{ isset($buttonSize) ? $buttonSize: ''}} btn-primary">
  	<i class="fa fa-tasks"></i> {{ $tasks->count() }}
  </button>
  
  <button type="button" class="btn {{ isset($buttonSize) ? $buttonSize: ''}} btn-success">
  	<i class="fa fa-check-double"></i> {{ $tasks->where('status', 'aceptada')->count() }}
  </button>
  
  <button type="button" class="btn {{ isset($buttonSize) ? $buttonSize: ''}} btn-danger">
  	<i class="fa fa-ban"></i> {{ $tasks->where('status', '!=', 'aceptada')->count() }}
  </button>

</div>