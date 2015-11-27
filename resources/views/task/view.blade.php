@extends('layout')

@section('breadcrumbs')
<li><a href='/projects'>Projects</a></li>
<li><a href="/projects/{{ $task->project->id }}">{{ $task->project->name}}</a></li>
<li>{{$task->name}}</li>
@stop

@section('content')

	@if (count($errors) > 0)
	    <div class='alert alert-danger'>
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

	<div class='row'>
		<div class='col-md-6'>
			<h2>Task view <small><a href='/tasks/{{ $task->id }}/edit'>[ Edit this task ]</a></small></h2>
		</div>
	</div>

	<table class='table table-bordered table-hover'>
		<tbody>
			<tr>
				<td style='font-weight: bold;'>Task name:</td>
				<td>{{ $task->name }}</td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Owner:</td>
				<td><a href='/users/{{ $task->owner->id }}'>{{ $task->owner->name }}</a></td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Project:</td>
				<td><a href='/projects/{{ $task->project->id }}'>{{ $task->project->name }}</a></td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Assigned:</td>
				<td><a href='/users/{{ $task->assigned->id }}'>{{ $task->assigned->name }}</a></td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Status:</td>
				<td>{{ $task->status->name }}</td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Created at:</td>
				<td>{{ $task->created_at }}</td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Updated at:</td>
				<td>{{ $task->updated_at }}</td>
			</tr>
			<tr>
				<td style='font-weight: bold'>Labels:</td>
				<td>
					@foreach ($task->labels as $label)
					<a class='btn btn-xs task-label' style='color: {{ $label->text_color }}; background-color: {{ $label->color }}'>
						{{ $label->name }}
					</a>
					@endforeach
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<b>Description:</b><br>
					{!! $task->description !!}</td>
				</tr>
			</tr>
		</tbody>
	</table>
	<div class='row'>
		<div class='col-md-7'>
			<h2>Task comments</h2>
			<form action='/tasks/{{ $task->id }}/add-comment' method='post'>
				{!! csrf_field() !!}
				<div class='form-group'>
					<textarea rows='5' class='form-control' name='task-comment'></textarea>
				</div>
				<div class='form-group'>
					<input type='submit' class='btn btn-success' value='Post a comment'>
				</div>
			</form>
			@if (count($task->comments) != 0)
			<table class='table table-bordered table-hover'>
				<tbody>
					@foreach ($task->comments()->orderBy('created_at', 'DESC')->get() as $comment)
					<tr style='background: #eee;'>
						<td><b>Date:</b> {{ $comment->created_at }}</td>
						<td><b>{{ $comment->owner->name }}</b></td>
						<td class='text-right'>
							<a class='btn btn-danger btn-xs' onClick='deleteComment({{ $comment->id }}, this)'>Delete</a>
							<a class='btn btn-warning btn-xs' onClick='toggleCommentEditor(this)'>Edit</a>
						</td>
					</tr>
					<tr>
						<td colspan='3' commentId='{{ $comment->id }}'>{!! $comment->description !!}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endif
		</div>
		<div class='col-md-5'>
			<h2>Task log</h2>
			<table class='table table-bordered table-hover'>
				<colgroup>
					<col width='100'>
					<col>
				</colgroup>
				<thead>
					<tr>
						<td>Log date</td>
						<td>Description</td>
					</tr>
				</thead>
				<tbody>
					@if (count($task->log) == 0)
					<tr>
						<td colspan='2' align='center'>
							No log records...
						</td>
					</tr>
					@else
						@foreach ($task->log()->orderBy('log_date', 'DESC')->get() as $log)
						<tr>
							<td>{{ $log->log_date }}</td>
							<td>{!! $log->description !!}</td>
						</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('javascript')
	<script src="//cdn.ckeditor.com/4.5.4/standard/ckeditor.js"></script>
	<script>

	    CKEDITOR.replace('task-comment');

	    var idCounter = 0;
	    var editors = [];

	    $(document).on('click', '.update-comment', function() {
	    	formContainer = $(this).parent().parent();

	    	var taskComment = formContainer.find('textarea[name=task-comment]').val();
	    	var formAction = formContainer.attr('action');

	    	if (!taskComment) {
	    		alert('Please, input the comment!');
	    		return;
	    	}

			editors[parseInt(formContainer.attr('commentId'))].updateElement();

	    	$.ajax({
	    		url: formAction,
	    		method: 'post',
	    		data: formContainer.serialize(),
	    		dataType: 'json'

	    	}).done(function(data) {

	    		if (data.status == 'ok') {
	    			formContainer.next().html(formContainer.find('textarea').val());
	    			toggleCommentEditor(null, formContainer.parent());
	    		} else {
	    			alert('Found some errors: ' + data.errors.join(', '));
	    		}

	    	}).fail(function() {
	    		alert('Comment updating was failed!');
	    	});

	    	return false;
	    });

	    function deleteComment(commentId, button)
	    {
	    	if (!confirm('You realy want to delete this comment?')) {
	    		return;
	    	}

	    	container = $(button).parent().parent();

	    	$.ajax({
	    		url: '/tasks/delete-comment/' + commentId,
	    		method: 'get',
	    		dataType: 'json'

	    	}).done(function(data) {

	    		if (data.status == 'ok') {

					container.css('background', 'rgb(232, 162, 154)');

					setTimeout(function() {
						container.next().remove();
						container.remove();
					}, 1000);
	    		}

	    	}).fail(function() {
	    		alert('Comment deleting was failed!');
	    	});

	    	return false;
	    }

	    function toggleCommentEditor(button, container)
	    {
	    	if (typeof container == 'undefined') {
	    		container = $(button).parent().parent().next().children().first();
	    	}

	    	if (!container.hasClass('edit-form')) {

	    		container.html(
	        		'<form commentId="' + idCounter + '" action="/tasks/edit-comment/' + container.attr('commentId') + '" method="post">' +
	        			'{!! csrf_field() !!}' +
	        			'<div class="form-group">' +
	        				'<textarea rows="5" class="form-control" name="task-comment" id="'
	        					+ 'uni-' + idCounter +
	        				'">' + container.html() + '</textarea>' +
	    				'</div>' +
						'<div class="form-group">' +
							'<a class="update-comment btn btn-success">Edit a comment</a>' +
						'</div>' +
	        		'</form>' +
	        		'<div style="display: none;" class="old">' + container.html() + '</div>'
	    		);

	    		container.addClass('edit-form');

	    		editors[idCounter] = CKEDITOR.replace($('#uni-' + idCounter).get(0));
	    		idCounter++;

	    	} else {
	    		container.html(container.find('.old').html());
	    		container.removeClass('edit-form');
	    	}
	    }
	</script>
@stop