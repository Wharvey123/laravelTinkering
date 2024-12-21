@extends('layouts.app')

@section('content')
    <style>
        h1 {
            font-family: 'Chakra Petch', sans-serif; /* Apply Chakra Petch font */
            font-size: 4.5rem;
            line-height: 1;
            font-weight: 700; /* Bold font */
        }

        /* Adjustments for content to be visible over the background */
        .content-wrapper {
            position: relative;
            z-index: 2;
        }

        .box {
            width: 200px; /* Augmentem l'amplada */
            height: 120px; /* Augmentem l'altura */
            float: left;
            transition: .5s linear;
            position: relative;
            display: flex; /* Flexbox per centrar */
            align-items: center; /* Centrat vertical */
            justify-content: center; /* Centrat horitzontal */
            overflow: hidden;
            padding: 20px; /* Ajustem el padding */
            text-align: center;
            margin: 0 10px;
            background: transparent;
            text-transform: uppercase;
            font-weight: 900;
            font-size: 1.2rem; /* Augmentem la mida del text */
            z-index: 3; /* Make sure buttons are on top of the background */
        }

        .box:before {
            position: absolute;
            content: '';
            left: 0;
            bottom: 0;
            height: 6px; /* Augmentem l'altura del contorn */
            width: 100%;
            box-sizing: border-box;
            transform: translateX(100%);
        }

        .box:after {
            position: absolute;
            content: '';
            top: 0;
            left: 0;
            width: 100%;
            height: 6px; /* Augmentem l'altura del contorn */
            box-sizing: border-box;
            transform: translateX(-100%);
        }

        .box:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.7); /* Augmentem l'ombra */
        }

        .box:hover:before {
            height: 100%;
            transform: translateX(0);
            transition: .3s transform linear, .3s height linear .3s;
        }

        .box:hover:after {
            height: 100%;
            transform: translateX(0);
            transition: .3s transform linear, .3s height linear .5s;
        }

        a {
            display: block; /* Tota l'àrea clicable */
            text-decoration: none; /* Traiem el subratllat */
            color: inherit; /* Heretem el color del text */
        }

        i {
            margin: 0; /* Ens assegurem que no hi ha espai extra */
        }

        body {
            margin: 0;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        header, footer {
            position: relative;
            z-index: 10; /* Ensure the header and footer are above the background */
        }

        .content-wrapper {
            position: relative;
            z-index: 2;
        }

        /* WebGL background canvas */
        #webgl-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; /* Ensure the canvas stays behind the content */
        }

    </style>

    <!-- WebGL background canvas -->
    <canvas id="webgl-canvas"></canvas>

    <!-- vertexShader -->
    <script id="js-vertex-shader" type="x-shader/x-vertex">
        attribute vec3 position;

        void main()	{
          gl_Position = vec4(position, 1.0);
        }
    </script>

    <!-- fragmentShader -->
    <script id="js-fragment-shader" type="x-shader/x-fragment">
        precision highp float;
        uniform vec2 resolution;
        uniform float time;
        uniform float xScale;
        uniform float yScale;
        uniform float distortion;

        void main() {
          vec2 p = (gl_FragCoord.xy * 2.0 - resolution) / min(resolution.x, resolution.y);

          float d = length(p) * distortion;

          float rx = p.x * (1.0 + d);
          float gx = p.x;
          float bx = p.x * (1.0 - d);

          float r = 0.05 / abs(p.y + sin((rx + time) * xScale) * yScale);
          float g = 0.05 / abs(p.y + sin((gx + time) * xScale) * yScale);
          float b = 0.05 / abs(p.y + sin((bx + time) * xScale) * yScale);

          gl_FragColor = vec4(r, g, b, 1.0);
        }
    </script>

    <div class="container mx-auto flex flex-col items-center justify-center min-h-screen text-white content-wrapper">
        <!-- Center the content with flex -->
        <div class="relative bg-white/20 backdrop-blur-md rounded-lg p-8 text-center shadow-lg -translate-y-20">
            <!-- More blurred translucent box and higher positioning -->
            <h1 class="text-6xl font-bold mb-12 leading-tight text-red-600">LaravelTinkering</h1>
            <!-- Main text size increased and red text applied -->
            <div class="flex justify-center space-x-8">
                <a href="{{ route('films.index') }}">
                <span class="box">
                    <i class="fas fa-film fa-3x text-red-600"></i>
                </span>
                </a>
                <a href="{{ route('cars.index') }}">
                <span class="box">
                    <i class="fas fa-car fa-3x text-red-600"></i>
                </span>
                </a>
            </div>
        </div>
    </div>

    <script>
        class Stage {
            constructor() {
                this.renderParam = {
                    clearColor: 0x666666,
                    width: window.innerWidth,
                    height: window.innerHeight
                };

                this.cameraParam = {
                    left: -1,
                    right: 1,
                    top: 1,
                    bottom: 1,
                    near: 0,
                    far: -1
                };

                this.scene = null;
                this.camera = null;
                this.renderer = null;
                this.geometry = null;
                this.material = null;
                this.mesh = null;

                this.isInitialized = false;
            }

            init() {
                this._setScene();
                this._setRender();
                this._setCamera();

                this.isInitialized = true;
            }

            _setScene() {
                this.scene = new THREE.Scene();
            }

            _setRender() {
                this.renderer = new THREE.WebGLRenderer({
                    canvas: document.getElementById("webgl-canvas")
                });
                this.renderer.setPixelRatio(window.devicePixelRatio);
                this.renderer.setClearColor(new THREE.Color(this.renderParam.clearColor));
                this.renderer.setSize(this.renderParam.width, this.renderParam.height);
            }

            _setCamera() {
                if (!this.isInitialized) {
                    this.camera = new THREE.OrthographicCamera(
                        this.cameraParam.left,
                        this.cameraParam.right,
                        this.cameraParam.top,
                        this.cameraParam.bottom,
                        this.cameraParam.near,
                        this.cameraParam.far
                    );
                }

                const windowWidth = window.innerWidth;
                const windowHeight = window.innerHeight;

                this.camera.aspect = windowWidth / windowHeight;

                this.camera.updateProjectionMatrix();
                this.renderer.setSize(windowWidth, windowHeight);
            }

            _render() {
                this.renderer.render(this.scene, this.camera);
            }

            onResize() {
                this._setCamera();
            }

            onRaf() {
                this._render();
            }
        }

        class Mesh {
            constructor(stage) {
                this.canvas = document.getElementById("webgl-canvas");
                this.canvasWidth = this.canvas.width;
                this.canvasHeight = this.canvas.height;

                this.uniforms = {
                    resolution: { type: "v2", value: [ this.canvasWidth, this.canvasHeight ] },
                    time: { type: "f", value: 2.0 },
                    xScale: { type: "f", value: 1.5 },
                    yScale: { type: "f", value: 0.5 },
                    distortion: { type: "f", value: 0.050 }
                };

                this.stage = stage;

                this.mesh = null;

                this.xScale = 1.0;
                this.yScale = 0.5;
                this.distortion = 0.050;
            }

            init() {
                this._setMesh();
                // this._setGui();
            }

            _setMesh() {
                const position = [
                    -1.0, -1.0, 0.0,
                    1.0, -1.0, 0.0,
                    -1.0,  1.0, 0.0,
                    1.0, -1.0, 0.0,
                    -1.0,  1.0, 0.0,
                    1.0,  1.0, 0.0
                ];

                const positions = new THREE.BufferAttribute(new Float32Array(position), 3);

                const geometry = new THREE.BufferGeometry();
                geometry.setAttribute("position", positions);

                const material = new THREE.RawShaderMaterial({
                    vertexShader: document.getElementById("js-vertex-shader").textContent,
                    fragmentShader: document.getElementById("js-fragment-shader").textContent,
                    uniforms: this.uniforms,
                    side: THREE.DoubleSide
                });

                this.mesh = new THREE.Mesh(geometry, material);

                this.stage.scene.add(this.mesh);
            }

            _render() {
                this.uniforms.time.value += 0.01;
            }

            _setGui() {
                const parameter = {
                    xScale: this.xScale,
                    yScale: this.yScale,
                    distortion: this.distortion
                }
                const gui = new dat.GUI();
                gui.add(parameter, "xScale", 0.00, 5.00, 0.01).onChange((value) => {
                    this.mesh.material.uniforms.xScale.value = value;
                });
                gui.add(parameter, "yScale", 0.00, 1.00, 0.01).onChange((value) => {
                    this.mesh.material.uniforms.yScale.value = value;
                });
                gui.add(parameter, "distortion", 0.001, 0.100, 0.001).onChange((value) => {
                    this.mesh.material.uniforms.distortion.value = value;
                });
            }

            onRaf() {
                this._render();
            }
        }

        (() => {
            const stage = new Stage();

            stage.init();

            const mesh = new Mesh(stage);

            mesh.init();

            window.addEventListener("resize", () => {
                stage.onResize();
            });

            window.addEventListener("load", () => {
                setTimeout(() => {
                    mesh._diffuse();
                }, 1000);
            });

            const _raf = () => {
                window.requestAnimationFrame(() => {
                    stage.onRaf();
                    mesh.onRaf();

                    _raf();
                });
            };

            _raf();
        })();
    </script>
@endsection
