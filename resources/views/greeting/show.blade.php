@extends('layouts.master')

@section('title','Мэндчилгээний үг')
@section('meta_title','Мэндчилгээний үг - '.$greeting->angilal->name)
@section('meta_image',"http://yaruu.mn/uploads/images/".$greeting->angilal->icon)
@section('meta_url','http://yaruu.mn/greeting/'.$greeting->id)
@section('meta_desc','Мэндчилгээний үг - '.$greeting->angilal->name)

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="alert alert-success" style="text-align:center; vertical-align: middle; padding:50px 20px;">
				<table width="100%">
					<tr>
						<td style="padding:20px;">
							<img src="{{asset('uploads/images/'.$greeting->angilal->icon)}}">
							<img src="{{asset('uploads/images/'.$greeting->angilal->icon)}}">
							<img src="{{asset('uploads/images/'.$greeting->angilal->icon)}}">
						</td>
					</tr>
					<tr>
						<td><span id="g_content">{!!$greeting->content!!}</span></td>
					</tr>
					<tr>
						<td style="padding:20px;">
							<img src="{{asset('uploads/images/'.$greeting->angilal->icon)}}">
							<img src="{{asset('uploads/images/'.$greeting->angilal->icon)}}">
							<img src="{{asset('uploads/images/'.$greeting->angilal->icon)}}">
						</td>
					</tr>					
				</table>
					
			</div>				
		</div>
	</div>


	<script>
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#greeting_link').addClass('myactive');
		});		
	</script>
	<script>
		document.getElementById("copy_btn").addEventListener("click", function() {
			var res = copyToClipboard(document.getElementById("g_content"));			
		});

		function copyToClipboard(elem) {
			// create hidden text element, if it doesn't already exist
			var targetId = "_hiddenCopyText_";
			var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
			var origSelectionStart, origSelectionEnd;
			if (isInput) {
				// can just use the original source element for the selection and copy
				target = elem;
				origSelectionStart = elem.selectionStart;
				origSelectionEnd = elem.selectionEnd;
			} else {
				// must use a temporary form element for the selection and copy
				target = document.getElementById(targetId);
				if (!target) {
					var target = document.createElement("textarea");
					target.style.position = "absolute";
					target.style.left = "-9999px";
					target.style.top = "0";
					target.id = targetId;
					document.body.appendChild(target);
				}
				target.textContent = elem.textContent;
			}
			// select the content
			var currentFocus = document.activeElement;
			target.focus();
			target.setSelectionRange(0, target.value.length);
			
			// copy the selection
			var succeed;
			try {
				succeed = document.execCommand("copy");
			} catch(e) {
				succeed = false;
			}
			// restore original focus
			if (currentFocus && typeof currentFocus.focus === "function") {
				currentFocus.focus();
			}
			
			if (isInput) {
				// restore prior selection
				elem.setSelectionRange(origSelectionStart, origSelectionEnd);
			} else {
				// clear temporary content
				target.textContent = "";
			}
			return succeed;

		}
	</script>
@endsection