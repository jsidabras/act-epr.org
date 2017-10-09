function changeFunc() {
    var selectBox = document.getElementById("selectBox");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    loadSTL("models/" + selectedValue);
}

if (!Detector.webgl) {
	Detector.addGetWebGLMessage();
}

var container;
var stats;
var camera;
var cameraTarget;
var scene;
var renderer;
var loader = new THREE.STLLoader();

init();
animate();

function init() {

	container = document.createElement('div');
	document.body.appendChild(container);

	camera = new THREE.PerspectiveCamera(35, window.innerWidth / window.innerHeight, 1, 15);
	camera.position.set(3, 0.15, 3);

	cameraTarget = new THREE.Vector3(0, -0.25, 0);

	scene = new THREE.Scene();
	scene.fog = new THREE.Fog(0x72645b, 2, 15);

	
	// Ground

	//var plane = new THREE.Mesh(
	//	new THREE.PlaneBufferGeometry(40, 40),
	//	new THREE.MeshPhongMaterial( { color: 0x999999, specular: 0x101010 } )
	//);
	//plane.rotation.x = -Math.PI/2;
	//plane.position.y = -0.5;
	//scene.add( plane );

	//plane.receiveShadow = true;

	loadSTL("models/slotted_disk.stl");

	// Lights

	scene.add( new THREE.HemisphereLight( 0x443333, 0x111122 ) );

	addShadowedLight( 1, 1, 1, 0xffffff, 1.35 );
	addShadowedLight( 0.5, 1, -1, 0xffaa00, 1 );
	// renderer

	renderer = new THREE.WebGLRenderer( { antialias: true } );
	renderer.setClearColor( scene.fog.color );
	renderer.setPixelRatio( window.devicePixelRatio );
	renderer.setSize( window.innerWidth, window.innerHeight );

	renderer.gammaInput = true;
	renderer.gammaOutput = true;

	renderer.shadowMap.enabled = true;
	renderer.shadowMap.cullFace = THREE.CullFaceBack;

	container.appendChild( renderer.domElement );

	// stats

	stats = new Stats();
	stats.domElement.style.position = 'absolute';
	stats.domElement.style.top = '0px';
	container.appendChild( stats.domElement );

	//
	controls = new THREE.OrbitControls( camera, renderer.domElement );
	controls.enableDamping = true;
	controls.dampingFactor = 0.25;
	controls.enableZoom = true;

	window.addEventListener( 'resize', onWindowResize, false);

}

function loadSTL(model) {

	scene.remove(scene.getObjectByName("stl_model"));

	loader.load( model, function ( geometry ) {

		var material = new THREE.MeshPhongMaterial( { color: 0xff5533, specular: 0x111111, shininess: 200 } );
		var mesh = new THREE.Mesh( geometry, material );

		mesh.position.set( 0, - 0.25, 0 );
		mesh.rotation.set( 0, - Math.PI / 2, 0 );
		mesh.scale.set( 0.3, 0.3, 0.3 );

		mesh.castShadow = true;
		mesh.receiveShadow = true;

		mesh.name = "stl_model";

		scene.add( mesh );

	} );
}

function addShadowedLight( x, y, z, color, intensity ) {

	var directionalLight = new THREE.DirectionalLight( color, intensity );
	directionalLight.position.set( x, y, z );
	scene.add( directionalLight );

	directionalLight.castShadow = true;
	// directionalLight.shadowCameraVisible = true;

	var d = 1;
	directionalLight.shadowCameraLeft = -d;
	directionalLight.shadowCameraRight = d;
	directionalLight.shadowCameraTop = d;
	directionalLight.shadowCameraBottom = -d;

	directionalLight.shadowCameraNear = 1;
	directionalLight.shadowCameraFar = 4;

	directionalLight.shadowMapWidth = 1024;
	directionalLight.shadowMapHeight = 1024;

	directionalLight.shadowBias = -0.005;

}

function onWindowResize() {

	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix();

	renderer.setSize( window.innerWidth, window.innerHeight );

}

function animate() {

	requestAnimationFrame( animate );
	controls.update();
	stats.update();
	render();

}

function render() {

	//var timer = Date.now() * 0.0005;

	//camera.position.x = Math.cos( timer ) * 3;
	//camera.position.z = Math.sin( timer ) * 3;

	camera.lookAt( cameraTarget );

	renderer.render( scene, camera );

}

