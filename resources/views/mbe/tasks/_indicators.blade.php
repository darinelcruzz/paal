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
  
  <button type="button" class="btn {{ isset($buttonSize) ? $buttonSize: ''}} btn-info">
  	<i class="fa fa-hourglass-half"></i> {{ $tasks->where('status', 'aceptada')->where('assigned_at', '>=', 'completed_at')->count() }}
  </button>
  
  <button type="button" class="btn {{ isset($buttonSize) ? $buttonSize: ''}} btn-warning">
  	<i class="fa fa-hourglass-end"></i> {{ $tasks->where('assigned_at', '<=', date('Y-m-d'))->count() }}
  </button>

</div>