 
 <aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="../dashboard/index.html" class="navbar-brand">
                <div class="row">

                </div>
                <!--Logo start-->
                <div class="logo-main">
                    <div class="logo-normal" >
                        <img src="{{url('assets/images/bfarlogo.png')}}" 
                            alt="BFAR Logo" 
                            class="img-fluid" style="width: 90px;margin-left:5mm">
                    </div>
                    <div class="logo-mini" >
                        <img src="{{url('assets/images/bfarlogo.png')}}" 
                            alt="BFAR Logo" 
                            class="img-fluid" style="width: 90px;margin-left:5mm">
                    </div>
                </div>
                <!--logo End-->
                
                
                
              <div class="text-center">
                    <h4 class="logo-title mb-1">BFAR LAB</h4>
                    <span class="badge bg-primary p-2" style="margin-left:5mm">Region XII</span>
                </div>

               
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar Menu Start -->
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Home</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                   <li class="nav-item">
                        <a class="nav-link {{ request()->is('Dashboard*') ? 'active' : '' }}" 
                        aria-current="page" href="{{ url('/Dashboard') }}">
                            <i class="icon">
                                {{-- <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-20">
                                    <path opacity="0.4" d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z" fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="currentColor"></path>
                                </svg> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                                <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAEF0lEQVR4AaxWbUxTVxh+eunCEMLHEAIjM9NNPoeCCVOHceAH0E10G5vsw2U/0A0zDNiMYYeCFRCxwwpd24HKh7I5xbhlC3OJ0TVjjmQq02WQZSyIUhc+ZYxLW1rWes4tPZHSYn94c55z3r7P+77Pfc897S0H+yUmi/8jBq0JKpC4ecurA4VFsvFHiXTJywPkhhM5sVicrVJ/HrxbWggHMje/ghdT1mHH+zuZz8F5uu4vOxQMcNm0Ay9yETGgu6sL0qyX0J73Nj78QI7sdw5DeUQJm80q8J5ONiFQBI6DFxUAvYaGBtFckIODoRy2LQlDUNBiLFtZjD9uJaHmaC0N8RgWiwV2EdKDI+tU4wnsXhQIL5HI4RLW0PAkXNSNwmAwCJ+dpy+/OIXXcvNRKNvDKJPJzGzWAX+rB8HejwkEb/kfgwO/ofNKuYDhwT/xd89fAuc83dXr8e+qN9A7NsmoSYOR2UzA5uMrtEWLy+904afGLnRoNQIKsi4jMDCIJc1nGIwmWKanWQgTSJZsQmvfEGjxykM8ngoDxF4gDxj4vX8FFoaEoId0cft2H0t2Nu7dG8WNmzcxMjLMKM5hbUzLQHdCCpLW8whfaPf+Q+LyFaHIyVPjhwtteL1cgy3bc+2ki1nx6WGUtp+BQqVgLBOgnoqDVQhb8RWk9W9CqpWgTrcHUvnPWBoZSWn4xydDHBwu2M6TmZwck9mCJyVrwPk+zuhZAtS7fsNGlJSpsbe8BfkFhXgimHxfKPEATjY34oXtWcjYmsm8jmPJHDMGEzjXegYH5CVzUFlRRp7D7HSz2YzF72bCFhIAo2lqppTrhQkEBgYhIiKCIT1dgpLSA5AV74NIJBIw3nkZ08N3BUH9hXaYBkaEEzN25TtYJ8Zgs1px5/wlWHmnY8pPGhAVE4c1a9cxLHp6CSZ4wwwmkbw2FS2f5KHpqBIpGySo3roLtfIj2PZeDo7tfAtV++XIzd0FxaYd2PvRPtYOZyWqxbIiKKoqoVbVMNCtKZZ9DDuKUC4vxfE6LRrqtVApFTjZeBwn6jRQ11QL9jHtZ9ColIJdp6lFdVUFaG2yRRwSEld5hOiY5YiOSfAoNiFxJemCo+8Dq9E8Nf+DIpHC4PkJ8Px/gv2waUqoaTXSLapvatDozrW29LrC2dNNo9+cP41vvz6LX9p1AqhNfZRzlUN9zQ1aHbmJerJF0Pf396Xe6Pz1GVcgPw1Xo56NR9TS52aD+EjeNVc51Ee4VCKgpwJkdTtWx8Ysy+DIm8M5gvqiI+PTiX81gdvhTiAtNm75eNLzyT/aRFb09Ha7hI2zgcbExsWPE4U0gjnDnYC3z4IF/v4BAd6+fn6YDzTGx8eP/iPxnlOdONwJtF2/2uF/6eL3HuH6tQ4q0EbqzRn3AQAA//+MoNCGAAAABklEQVQDAF5HOO/PT8uoAAAAAElFTkSuQmCC" x="0" y="0" width="24" height="24"/>
                                </svg>
                            </i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('clients*') ? 'active' : '' }}" 
                        aria-current="page" href="{{ url('/clients') }}">
                            <i class="icon">
                               <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                                    <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAFZUlEQVR4AeyTe1BUZRjGn3N295yzd5aVXREQFUQTDcY0LwPegQRFk0adMrUmpVKcLLVQxEp0psFJrSkmG8z7LTANwQtjkY6hljeQi9xNQFhgF9hdd8+eW2uDjg6O5R/+1zvzzffNN9/7/N7vnfch8Zzjf8C/NviJLVp66M/YqO35+5efLVtVJknU01TezNq37oWV6wsX7D244UnvegFW/1Qa+2tt6+kaQvd67pWKzOzThey5rtKETWfWbk4/vvTCmn3vnPq+KGvFfbFFGdvy8opvZDQJqmn7Txd/Oj0zK//+/aOrF6CN1Cd2Uwa45Cp4ZBRYkUCTzTLJyrenNrJ14+3q1rgK67XMHy7mfBI0dHAnRZthdzDQ+oXgRk1j/NU2Z7+nAq5XVS6TaAZdThcoioFOp4PD2TnS1t0KSgtIjAtOrpUiaT5IIjkTy0kgSQ1YFwGPByAZueGpgOB+GsBtg1YmA80DkWGD0Xr7zhSDSgWS9UDm4aBTUrA0VoaPHBHSxigAgXVDJolQ0nJvYV3za61WPXqiV4sWzh0XpYUbWnggOjvByBVQU2rALXoUogIUScHjZht1em0gz7MmjrVDp1FActnBO504lnM0zWRQ0OiJxwDNkqTyk6MqgJGglmzoa6Dhb9DkvjI16Xc13aeLJrQQeBISqL6TomcXtbY7RlEqAhzbDrOWQfyECZgcPfWyAxqpRx8PAeUuKTj7ZEnJkdxLlnUpCTPHDjFjTXJiUcGp/KTqupv+Ro3ZJuOUYAQ9gvxCOA/PGQcFm0tjxw+HmmvHxBfDsHjuzPNukeKtDky0SZJPuyQF/ANI2HmiPu7rQw3f3awKKbpVD0sbVgxUsQiVuZjIUGXl0EHGijEjR92gWC18hX4YHxZ1nO204OUg/zPvz4nKHxugRMqc6fsNFLjdxwrGL0rN+HHzwfy0WhYnyI/rPBElnZ4Bbdp+6FD5gtIwIISuwLjogderq/Pst6p/Gbrr0PZ4wEMmJryKmClxTh+tht9zOGv23pNbMmprCpXpqQuyTFr+WsnVcoeh/yA0OATsOfHbR+dKmyLJthYxlhMNcHtnmfCQCA/pCx91R1lObkZk8dWDMS2uKtjRgfK6iiSPzI0W+x31peqiBapgHvXu6zhfe3TK7oIt79Va/ph69uLJiMLiC+gmaUBrRoPFAbLT5TZDkkFH09DLgUA/JW5VFpsEWCGnHRCJLtBKAU2WWpTVXEGbuxmN9gZYuVawTDc4ZTcElQPlTSWuiKiIZZJM9M6t1y+iHA31dyXSznUyFM1Cx92FoqsBwQOMsLOOAF6AdwIUUEoC5IIdLlcTmq2V+Mu7OlwtYAkRkCkhSgQEuYQ7TqukMaptap792UxKLNHtdClFWR45wqjIjhnctyAuxIjXxgyBiRFgt1pCfHx8IYgSeK+BeIn32sCJrntWdHZ3gOM4yEGD9AAaiQbjdbNCEoabjT5N0eH9D8eOHPJ20uQxCyMH+O8kvxwdcC17+oiE1Gmjj6yOGYdROn2H4p4Nnnt2709YCJQSbhntrVIDTqTB2iXQnBJG0gcapwI6BwG1jQXT3sEmGIbd3vNhyoHslKQD3747LSctcfBxEj0RqiHm+RMEwYhu4xDzQBgpM0L9I+DLBCNQPwxmVdiFPopB2wK1wzYFKMM+74P+GUFMSGZ/VdiOoX7hu0yk7+Ueqce2h4AHt3qyT/qs6PnCwmnLmhdNWp6cHPOZ9o2XlhjXxm6LSp/xzcrU+K/SVsVv3bBm1tb1H8ze7vXi1uTFM754a8m8jUseaDy69wLQhGKjr8IkD1CHBfgRoTtMhMkRpA+3Ppr0LOdegGdJ/i9vnzvgbwAAAP//VDBfdgAAAAZJREFUAwDNskpPGGqMRQAAAABJRU5ErkJggg==" x="0" y="0" width="24" height="24"/>
                                </svg>
                            </i>
                            <span class="item-name">Customers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" 
                        aria-current="page" href="{{ url('/users/index') }}">
                            <i class="icon">
                           <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                        <image xlink:href="data:image/png;base64,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" x="0" y="0" width="24" height="24"/>
                        </svg>
                             </i>
                            <span class="item-name">Users</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#horizontal-menu" role="button" aria-expanded="false" aria-controls="horizontal-menu">
                            <i class="icon">
                                
                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                            <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAEgUlEQVR4AZRUC1BUVRj+2GV3WRDMmUwJEqOBRBAQEnkYULwiFrZgQdFSUNlEyCl0tAZxyspkCoExAkaDQohHScsKKFqiJlQ0sLDxJmecSR4LMsNjSPfduddYoL2Q3Pm/e8/5z/d/37nnnHtZ69bZ9gsjw/XLhffWF9Q8Hi8E/3OxPNw3OexNiIeFOZ/GejsbSCrOwtfbne7P5v/75JvxTIn2aS6Xu4M8Fw0WNVL5nQRnTu6B35b1eM7WAgUF+TA3fQAvN9tFIQzzxOkTYg8TE5MTPB4vitJhAm1ADfx4sxX3RrV4fpMv7Dd4wdHFB05ufktio5svpFV5Ttt8PCREg09gFAYDrUYLV9eNCA0OXAYCEBrkC+u1q02IMpvAKAwG80cGB4fR2tbBiO6ePgN1YnIK54q/h6yjB2QvighOcjgcNwOBNBgN5J09uHK1kRHXG2+TMqBaUof4N7fjiVW9uFYrguLu0dgL5wUZT9o8KzM3tygiJDMCMBqEh72M9PfeYUTqwX2QSC+jvr4QNZUixAidseapFbCy5OP3tnEkZZaaiHN+SLSwsqoiBiaMBqXlF7H/QJoROrt6MTPzN/ILspGXLYCp6Vz55NRDNHWawWXzFjj7hkCQ/GEkWbL4OQaxmw3R6xHIPJVhBKcNDpDWNSA+zhEczsLS4pI2+Mckg9ptHtnubSIx+JYrxQtZ/zqw2GzwuNwFsLJcATbJy2R/wMfrGcy/1GotKmtH4PGSgE6bEheumTlsHd09GQ3KK6qR/PbRBaiuqaeLVWo1OTFkinQP0Gh0eCv1ElzMHJGfEI7C40n4pa4cU/dHwOZwuIwGe8jpuFCch/nYLhLSko4O9ujqGaXblLg45RIirJPw1YEzaDxcgm+CU+A1MI6u9EPob7nRx2hAVy9yEwpeQcm3cnrms+Kx3pEG9tOr1uKNzULEuIVDp9NULGmg1Wpxb3AIg0PDBgEbG2u4uIQg6NWvycz3I9b70bobCA+00CjVOCL5ZEClUuUuadB4owm7hamIDkvE/C/4+PvvwtMzCL/9KYNicsygrZ5WQtp8BUPTg5/2Dd9xJgMzSxrodDrE+kQh1DUQZ78sQlZOPqkBWCwWcrI+QmRqMA5fTYf/x68hIEM4Zpe2tTmuOCXNLt3/A0JUEzB/yRqNBgcPHUPuF+coDo0VrpGorLtNt2dvAS/6oLQoE3ZOa3Crt8V+eELhp1Qqs8m4ioAOxjdQqlQYVbRh987VNIm6Wds5gMe3oJrLAqMBpcDjsrHSiv5fUV0j6PWAVqcl0EFPdYwYjxKs0bFxjUIxt1FUuqJKgpbWEZz6rAnFN8shlTWgLDMNd3vlkNY2UBTExe9FtGgXAkN34WLNtfskaVgW0jYEi/z3o5qbW9oNGdLYl7ATA93tuHX9Z7TIG9DR3YjWn8rwV/+viBKEEQagfDiN8zlHQJZzjByGIJJkNiCbclmr13+enJbVRUiPHROTM4jYcWyso/NOsEqlki9WyKIGCKFMpdGIs3MLVdFxiXgctMv7Rol4EKldVJzS/gcAAP//26S4IQAAAAZJREFUAwC1SvqDeyEGfQAAAABJRU5ErkJggg==" x="0" y="0" width="24" height="24"/>
                            </svg>
                            </i>
                            <span class="item-name">Documents<span class="badge rounded-pill bg-success item-name">5</span></span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="horizontal-menu" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('QM/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/QM/index') }}">
                                  <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                  <i class="sidenav-mini-icon"> QM </i>
                                  <span class="item-name"> Quality Manual </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                     <a class="nav-link {{ request()->is('SOP/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/SOP/index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> SOP </i>
                                    <span class="item-name">Standard Operating Procedure</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('LF/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/LF/index') }}">
                                    <i class="icon svg-icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> LF </i>                   
                                    <span class="item-name">Log Form</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('LR/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/LR/index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> LR</i>
                                    <span class="item-name">Laboratory Record</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('WI/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/WI/index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> WI </i>
                                    <span class="item-name">Work Instruction</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                      <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Pages</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-special" role="button" aria-expanded="false" aria-controls="sidebar-special">
                            <i class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                                    <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAD7UlEQVR4AbRVbUhbVxh+btS4JJ1LNLHFgqRFcTCJZXSwH9swlmxYqVa7yqTCBrIP0T9l7IeMSae4tlCbMqqu26J0tBJWJQ5jdWkXZymWlRlXdEzG5rboujQfjS3mW83OOUnuvF4nFdrD+5zznvd9zvvcc++590rwhJtAQCqV6rRa7VvabUChUOzb6hoFAh0dHaOTk5N920FbW9u1RxbYQdpW5M1yZAc7knF6sSVJnx9okJ9sdCYmJjAyMiLA+Pj4Rhqbv4Ss9z7F3m/JREXA26YCPp+PFV1eXuaJKScYDLKc1+tNheiY1Yxd7U3YtfMI1C00kMKmAjk5OaioqNgSarU6VQM7IT1YA3W2BBwOQXmMTxBHQiCwaDSKz7qvoO/LMUxN3RHk/m9yD9HZm3gYjWANdxB0rOeJBCKRCOZ+2osHd2vx69xdxp2ZmYHVahWgv78fRqMRFoslU6PRnC7D7D41bh81gixkqxKdSIDjOLg8t/DbX99gLR5hLI7jwHEJuFwudHZ2wmQywW63gzwLLjMzs4wQ/1zG6gAZQwS8iQToSTVbmnHepMex+sOMWFxczD+PqqoqJkYTBQUFaGxsRF1d3fdkLihM5sxEAuFwGJ+0X8a5MzbcuHGLkejJ8fv9oEhPT0dTUxNaW1thNpvR0NCAA6QRYjaByEQCsVgM7oVngeDr+HthiS1wOp1wOBw8lEol3G43y9FOr9dnkF0mtksD6yASSEtLQ2R1CveWLJDJE2mO4yCRSASg74r5lBGDp85h+Gw3ihTZtdikJSqsS8jlcvSY3sHJswdwuPo1likqKgK5SmSEY1i6PcP8+vp6ZJ24iCMtAwzv/uAtI+QcAoGJBEKhED443of2j65jdDTxWVhcXMT09DTWPryA57ttsH9nx/z8POZKdvPFSqHM0EFezQeSjiQ58sPKygpiAR2ezqjB0v0wiwcCAdz86mvUuDi8GJNh4fxleDweRA37ESQvFyVlgMMbyBXdJpEAPSUK1SxCGIRao6BroVKpsOfnf0CL0IB22on8/HwYqithf+q/07kfCj3Jqwl4EwnIZDJ0nH4TLa0GGF59hRFzc3PBGV6AH2R3iMP38nMoLCxEXl4efGU6xqFdKZ5JL4G8hvopCATi8fhaKrFxLH+/EVcvvI1LZ2pR/vlJPh0o1QluUx00R/kkcQQCQ0NDbV1dXcME1o3o6emx/uL8w/q732Pt7e1N5YcHx66euAZ/kNRithtSwS9UIGCz2Yzkt1lJcOgRUUm+Rx8PwPeFFzHcJ7fwOh5cYUrJTiCQjG17uATPcS0c5Xvw48GLcDevL/BYBEjBeAArYw+xOkp8wXP8FwAA//8tdCztAAAABklEQVQDADqusUBxEN2oAAAAAElFTkSuQmCC" x="0" y="0" width="24" height="24"/>
                                 </svg>
                            </i>
                             <span class="item-name">
                                     Laboratory Test

                                        @if(isset($analystWorksheetCount) && $analystWorksheetCount > 0)
                                            <span class="badge rounded-pill bg-danger">
                                                {{ $analystWorksheetCount }}
                                            </span>
                                        @endif
                                    </span>
                            {{-- <span class="item-name"></span> --}}
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="sidebar-special" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('lf_06_02*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/lf_06_02') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> RLA </i>
                                    <span class="item-name">Request for Laboratory Analysis </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                  <a class="nav-link {{ request()->is('lf_06_03*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/lf_06_03') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> OP </i>
                                    <span class="item-name">Order of Payment </span>
                                </a>
                            </li>
                            <li class="nav-item">
                               <a class="nav-link {{ request()->is('lf_06_04*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/lf_06_04') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                   <i class="sidenav-mini-icon"> JRF </i>
                                   <span class="item-name">Job Routing Form</span>
                                </a>
                            </li>
                            @if(Auth::user()->role == 3)
                             <li class="nav-item">
                                <a class="nav-link {{ request()->is('reagent-media-logbook*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/reagent-media-logbook') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    
                                    <i class="sidenav-mini-icon"> RML </i>
                                    <span class="item-name">Reagent & Media Logbook</span>
                                </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link {{ request()->is('sterility-check*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/sterility-check') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    
                                    <i class="sidenav-mini-icon"> SC </i>
                                    <span class="item-name">Sterility Check </span>
                                </a>
                            </li>
                            @endif
                            {{-- <li class="nav-item">
                                <a class="nav-link {{ request()->is('analyst_worksheet*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/analyst_worksheet') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    
                                    <i class="sidenav-mini-icon"> AWBEFFP </i>
                                    <span class="item-name">Analyst Worksheet </span>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('analyst_worksheet*') ? 'active' : '' }}" 
                                aria-current="page" href="{{ url('/analyst_worksheet') }}">

                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>

                                    <i class="sidenav-mini-icon"> AWBEFFP </i>

                                    <span class="item-name">
                                        Analyst Worksheet

                                        @if(isset($analystWorksheetCount) && $analystWorksheetCount > 0)
                                            <span class="badge rounded-pill bg-danger">
                                                {{ $analystWorksheetCount }}
                                            </span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('equipments_usage*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/equipments_usage') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> EUL </i>
                                    <span class="item-name">Equipment & Usage Logbook</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('environmental_plan/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/environmental_plan/index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    
                                    <i class="sidenav-mini-icon"> ECF </i>
                                    <span class="item-name">Environmental Condition Form</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                  <a class="nav-link {{ request()->is('sample_logbook*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/sample_logbook') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> SSDL </i>
                                    <span class="item-name">Sample Storage & Disposal Logbook</span>
                                </a>
                            </li>
                             
                             <li class="nav-item">
                                <a class="nav-link {{ request()->is('reporttest/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/reporttest/index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> RT </i>
                                    <span class="item-name">Report Test</span>
                                </a>
                            </li>
                            @if(Auth::user()->role == 2 || Auth::user()->role == 4)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('/healthcertificate/index*') ? 'active' : '' }}" 
                                            aria-current="page" href="{{ url('/healthcertificate/index') }}">
                                        <i class="icon">
                                            <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"> HC </i>
                                        <span class="item-name">Heath Certificate</span>
                                    </a>
                                </li>
                            @endif
                              <li class="nav-item">
                                <a class="nav-link {{ request()->is('releasing/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/releasing/index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> RRL </i>
                                    <span class="item-name">Receiving & Releasing Logbook</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#meow-menu" role="button" aria-expanded="false" aria-controls="meow-menu">
                            <i class="icon">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                                <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAEBElEQVR4AZyUD0yUdRjHv9whRQeH5YCReK4/tEaT4OrG9JI7VALPOQlbauXNNpEs1ArmbpVki+gPInM1+jNbOZw5KRUXcFy64/iT5xhKieCfIKrBcQgHlECk753P8+od4vvq0O35vO/vfX7P83zf318FgBDCQBjvkoco75bGAvNDI2PqYhdn2u+USO0zdqpcQtzSWCBoVkIydAVfIHbRijuCBLjwXHqsI+IJibGA6HQ1WjG6fxcS/2qdNinKcbyas0Wbakz7lopkExILCHCPfoEBHxbuxHsFH6NgW5EshR+UiDEc52flyjWcLssUAY4QBAEphkQkah+R5XBlBYeJCMIV2GxVqK45wt/z6fESoSICJhFQKpVwHm9Hx5keWZ7LfEFMPneuHcZULcq/yYVK8RuQeH8yMmL2YoaikwIyCNEkAgKNYEPOy1hrzpKlznEUfX29WLU6HUV5sTi8Ox3phjlAXDjwzhPA8tnRQUAlVecRQSLAI8jJ2cyLJ8uTCVp88un7yDVrYFqkoTo3WPkf0NWP4YAxhc/WLu6RCPh8PvT390mIioqGXm9ARMRM1NQcRPaaxzl/kjo3dAeHYU1bjKy5GjymVj9NnRpZgaYmBxpvorPrAsUDo6OX4BkaQtLSHxGXsl/EUnQCOl8Yaqn4zBD+eZoxdTjNFKQCCoUCvBVLdpThRjLSl4sCoaH3QX2vCicXLsVpwzKRLlMmmkwZiLhenANd4+P8uigZAS/yU7o4PPzorCl89vkOTkBwcDAWGJfA2tMLFbX9KIP4h8UQnBkexqlBD++m84prrsknL3JL8wV0/T44hU25+YEgy9btsPzahrMjIwGfvzE4MQFzQxOtJCzk80kEyBmw7/Z8jfUbXsTG18zi3Ps74uPnofjLcjzbcBzbTrWi3t0P58UBlLZ3IOlI1ZVWz9CbFPsDId2m7HS7XeCFrqjYi0NxbhxwVmHQM8BdAdKWmHCsgQ7YslV4o3cA+mprV35zS3HP2Ng8ChK3KL3lBXi+t7++Fn92UIGEGCAsBHX2n+FwHOOcAJGR0ch7621kZ+eyj++LrdQ4SwRMdor4LGxaqEeyZvIg7aw9iudXmwKJ023ICsglJ+UXQzHjHrmu2/pkBbxeLy4LXgheH/C/ANBLuDxBhXzg0VEDefkb8WCsCrPnhGHzlvXsGuXHzYgCw+dPo7vqe7GPz4HdbsO7jkacGPAgylKPKI8Cza8Y8UC4Gv7reuSfEZSWliMrywz6IRslFxISY4GWS393ruv7xbabe/kcTOe65tiyso+wb99XXHwFff9HSIwF/iXvHqLBWvuT7BUtd3U7nY1oazt52+JUc8o2PdTd3ZlaXVM5LVyunlQqkEnI/jn5RbsKAAD//yB+6GMAAAAGSURBVAMAmcoAZdfKQwEAAAAASUVORK5CYII=" x="0" y="0" width="24" height="24"/>
                                </svg>
                            </i>
                            <span class="item-name">Reports</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="meow-menu" data-bs-parent="#sidebar-menu">
                            {{-- <li class="nav-item">
                                <a class="nav-link {{ request()->is('QM/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/QM/index') }}">
                                  <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                  <i class="sidenav-mini-icon"> LR </i>
                                  <span class="item-name"> Laboratory </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                     <a class="nav-link {{ request()->is('SOP/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/SOP/index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> E </i>
                                    <span class="item-name">Equipments</span>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('payments.reports*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/payments.reports') }}">
                                    <i class="icon svg-icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> PA </i>                   
                                    <span class="item-name">Payment Analytics</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('customers.reports*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/customers.reports') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> C</i>
                                    <span class="item-name">Customer</span>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link {{ request()->is('WI/index*') ? 'active' : '' }}" 
                                        aria-current="page" href="{{ url('/WI/index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> WI </i>
                                    <span class="item-name">Work Instruction</span>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('text_blast*') ? 'active' : '' }}" 
                            aria-current="page" href="{{ url('/text_blast') }}">
                                <i class="icon">
                                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="25" viewBox="0 0 24 25">
                                     <image xlink:href="data:image/png;base64,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" x="0" y="0" width="24" height="25"/>
                                </svg>
                              </i>
                                <span class="item-name">Text Blast</span>
                            </a>
                        </li>
                        <li class="nav-item">
                               <a class="nav-link {{ request()->is('citizen-charter-survey*') ? 'active' : '' }}" 
                                aria-current="page" href="{{ url('/citizen-charter-survey') }}">
                                      <i class="icon">
                                           <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                                            <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAElklEQVR4AbSTe1BUVRzHv3t3Ly95LYS7qLC8HwY4a8EMCDkNbKIZVn84OkaTAmnjRAMRghpTljxSYBq1CWaEMTIyYrBxCZhk+EdACMKAFFSeIgTLQ9g3sWzn3mF3uMY20Yx3fp/zu+ec3/l977m/cyg84+ffBGh/kUOJbJt7M/mGlwj/y9YS2CKgqGyS7ezeCI93XYXOUbFh7qWkf9yKzz9I/LqMEYje/3JIW/JrET0M0oBNHT+djM0tT435aEewGOHeDkiSBQbWZMVePLjT+9ukveFsHONDfUVfEzWKYNGo2O1emXERQRHuHn4hDEKhq+jWvUncfzyPzoFpTC/o0DM8i/YHCjxSqCnxSpyNvTAkbX/MUZI5lGDRqA00bTUyrUNmwVWWq9ebkfjZjTX5qqodWV98x8Z5SveAT/GYxFZMYwnO9grOHMXlokRUlqZibm4GXV0daGr6xczs7IylPBbHOQLqsRvY6dcL+6V29Pb2gMfjYXnZaKa//x4Z77aYbK0JjoCDHYXGDhUOyJxXYnlEBGbUahUGBwcwNTWJ//pwBJwCU0GJDqCsbReioqIhkUgQEBDEYXFRj5zcXNR0T6B40BuecYfLbFzEOUTQifAP4wgcSUnHex/k4f30PHh5+SAsTIrIyGgzWq0WF5tHMeSzD5SNA7a4OkMk8Q8Jz67+VLIrhfl3W59W4AhEpmxDWJEvgjM9UVcnR0VFOYqK8llOn87EmdoeCGhrHPeaR33xSVTmZaPhXAYS+N0QS+M8Ja8ckRMBe4LZOAJKgRKGeQPoTTQ5RbPmIOale2gctHsQTsgCkZDwBqkLD8xD0zSOpRzDPpcpeMqSvQUbnJm7wUyxcAQE1gLQYhrW3tbg8/lsgKl54ugH+4lOyGTxpiGOT34nCcq+WxC/uPvV1RMcgYqkKny5tRSFwkvkK99EYuJhpKdnITU1A3qBHdwd6NVrOe+2trZw5i/B2tFNvHqCI6DTaaHVaqDRaGAwGGA0GlmY3djxFjGp+mv1Ws67TqfDkyU+9EoF5wxzBKqSD2EhJxPD2WmQy6+TIpexBWYKLZwfwPxGKbnVNzmJTZ3yb8rhEByDqc76OtMY4zkCIvLfq2Zm4CoQkNu7TApJEXgs2/09sKQYxNna39HQ8DOzloXZafmVy6j+0wnD9SWqReVcCTux0lArnnWD9o7Y4eSMLr0ebm5u7JipsbOzg3SpH0tGCoV3+diT9jnePpWH+PR8/KAOxERXo8GHT9tbWdl8T9Z4EFjjCJS03MGJP4Zxvm+MnJbd5iIzhWYoLr6EK6mv4wXVr9CTeg1MqzEx/uj+b+ffyh29WebT3lzdJ41JihdtDm0i2VkRihTSKOAZUJj/MUtRQQ4YTP2n/Y+VZXiO1sNjoRsZPg8wUl9ySKMYOUUSjmrVc0ljQx1K3+djfU0iVGv/eA1vedHguHAH6yFKAlxr7L5LEjMQx1rL48G2+JGHt1kRJ5fN56jpeU3pJ2WNwvQLctF6+PCCfGNta18oSashrDYicju+r0veqlLN1phqoCQRU+tEQeKXCWtZy6ziYZRhUXvtbwAAAP//1kkZaQAAAAZJREFUAwA7S/tAbBMPCQAAAABJRU5ErkJggg==" x="0" y="0" width="24" height="24"/>
                                            </svg>
                                        </i>
                                    <span class="item-name">Arta Survey</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu End -->        </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>   
    <main class="main-content">
      <div class="position-relative iq-banner">
        