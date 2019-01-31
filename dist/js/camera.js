var btnCameraOpen=document.querySelector('#btnCam');
var btnCapture=document.querySelector('#btnCapture');
var canvas=document.createElement('canvas');
var context=canvas.getContext('2d');
var localStream;
var photo=document.querySelector('#img');
var video=document.querySelector('#videoCam'),vendoUrl=window.URL || windowwebkitURL;
navigator.getMedia=navigator.getUserMedia ||
				   navigator.webkitGetUserMedia ||
				   navigator.mozGetUserMedia ||
				   navigator.msGetUserMedia;
btnCameraOpen.onclick=function(){
	navigator.getMedia({video:true,audio:false},function(stream){
		video.src=vendoUrl.createObjectURL(stream);
		video.play();
		localStream=stream;
	},function(error){

	});
	document.querySelector('#btnCamModal').click();
}
btnCapture.onclick=function() {
	context.drawImage(video,0,0,300,200);
	video.pause();
	localStream.getTracks()[0].stop();
	var base64=canvas.toDataURL('image/png');
	photo.setAttribute('src',base64);
	photo.style="z-index:0;width:200px;height:200px;cursor:pointer;";
	document.querySelector('#picture').value=base64;


}
