@extends('layouts.app')

@section('content')
    <style>
        /* Apply to html and body to prevent unwanted horizontal scroll */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden; /* Prevent horizontal scroll */
            height: 100%;
        }

        .container {
            width: 100%;
            height: 100%;
        }

        /* Adjust canvas to be responsive */
        #webgl-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw; /* Use full viewport width */
            height: 100vh; /* Use full viewport height */
        }

        /* Make sure content stays within viewport */
        .content-wrapper {
            position: relative;
            z-index: 2;
            overflow: hidden; /* Ensure content fits inside the container */
            padding-bottom: 60px; /* Add padding to avoid footer overlap */
        }

        .box {
            width: 20vw; /* Adjust box width to be responsive */
            max-width: 200px; /* Prevent excessive size on large screens */
            height: 15vw; /* Adjust height to be responsive */
            max-height: 120px; /* Prevent excessive height */
            float: left;
            transition: .5s linear;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            text-align: center;
            margin: 0 5px;
            background: transparent;
            text-transform: uppercase;
            font-weight: 900;
            font-size: 1.2rem;
            z-index: 3;
        }

        /* Ensure the header and footer are properly stacked on mobile */
        header, footer {
            position: relative;
            z-index: 10;
        }

        h1 {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 4.5rem;
            line-height: 1;
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center; /* Ensure it's centered */
        }

        /* Responsive text sizes for smaller screens */
        h1.text-red-600 {
            font-size: 4rem; /* Increase size for larger screens */
        }

        @media (max-width: 768px) {
            h1.text-red-600 {
                font-size: 3rem; /* Smaller font size for mobile screens */
            }

            .box {
                font-size: 1rem; /* Adjust font size of the box */
            }

            footer {
                position: static; /* Make footer appear at the bottom in mobile */
            }
        }

        /* Flexbox container adjustment for smaller screens */
        .flex {
            display: flex;
            flex-direction: row;
            gap: 1rem;
            flex-wrap: wrap; /* Allow the items to wrap on smaller screens */
        }

        /* Ensure footer is at the bottom */
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 10;
            height: 60px; /* Define a specific height */
        }

        /* Prevent footer from causing unnecessary scroll */
        .content-wrapper {
            min-height: calc(100vh - 60px); /* Adjust based on footer height */
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
                        <i class="fas fa-film fa-3x text-red-600 sm:fa-2x md:fa-3x"></i>
                    </span>
                </a>
                <a href="{{ route('cars.index') }}">
                    <span class="box">
                        <i class="fas fa-car fa-3x text-red-600 sm:fa-2x md:fa-3x"></i>
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
