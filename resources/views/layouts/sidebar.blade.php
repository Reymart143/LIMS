 
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
                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="28" height="28" viewBox="0 0 24 24">
                                <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAD1klEQVR4AeyTa0wUVxTHz51ldwf3CSwLLGyDFSoUKoIka6sYw7a1JLVpTWmFprQN6QdqaKs11gDFFpZNJba1WIu0wecHPykaNSKabAivIPFFkAVRdMUFYQfZ1ywwu+x1ZsMkPsDFD34wcTJnzr3nf+75nbm5l4AX/LwCBN3gBW8Rxlh4C2PFHYwXj2Oc4sRYFbQ6m7BgwNY9uz/7zWj4vtxQfdnwz789TR3N3RT2FbDgELbOvG9QQGFF6dbaUyc+yd/4ReehkrKqqrJtmoK8XNOIwxbzk7HkUNt9CzOK8ar5CM8EfFlZllxfXrWraP3HDSvU6psIIb8Wocl0lTq7OCcXbSneDP8dqEfXh/pbnxuQV1K07MgvBjO/EFNULG5rw57G85gdJ3HxNHkMKi3e3na4bj94sedtLvakzfkHza3/bzhqrO3mk7GN1lz6a7epo24ftOytgfZfK8x4hPqa05fKJKs/0CVAT0fDW9z8SXsKYL+7L1Pi6TrW22pYySfTFy99ji3DiVqvDzS0E5i+K+BoOX2A13WxLiDGLtRNmff+ycd4/xTgwVB/YxhyADExWIXHTFIukXHZI2SkAAS+aQhhpkEuFANNu6Y5DXvOaUX0PRxDusHa376Ziz1qxKMTbhwt06yXE0pQL1I3QaSN4WJhGQlNdgFtckvQ0KREQdnFCrMmM+tbToNQ0UiYSGoReRG8ptayB2pAHojPfohZH3DOexciEONqV0lCQOB1/A5dwzsDAnVrSpejtySmvmlMSUvvzF730UUYpVwBzTzQTfid8YpwEThtlihsuVsfiM9+HgM47nTcpt1mcDn7wD12DR70NBfg45X7u2r31N9uOKUDyrPJR9n1vcePfdVZXd2AD5Zj12BLMsAgMBO94PdZ4erlxk8xHhDP1ofHAHHxCXkgiZl2+OQglmohPHHZ6Rumlm/CZnCqwksk28w3Uod6+8hQxgNKtwOunWkEWexSGGckMAGR4AuNg/SVgTsnnxMAsRvPRmQWa+OydmRHZG35EDR62j6lBKFQBUD7QDoDIGNbQl4GsFAIox4SQL4Wopdvg6h3/4Do9yoBolYbEUq0zQlA7E3lRCRbbkKRujNoyZrv0nJyd1r9YJ1UhoOdJGGcJMCuWARWsQiy8gsBXl9FCpQZCJGpCAmXICRQlfLFOc/2w7n5jdyQu/2dih2biDU6GE6Kh7GUN0D4/lrQ/72rJjR/nZRtKnBc56sQFMAtRIuTTmoKi9CKymqBvqY2JOXHnwUoOeMHhKJpTn+WLQjAF2C79bM2w5qfjwXzzwUIVmwu/eUHPAQAAP//mvkl9QAAAAZJREFUAwAfL3JA5tx3ngAAAABJRU5ErkJggg==" x="0" y="0" width="24" height="24"/>
                                </svg>
                             </i>
                            <span class="item-name">Users</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#horizontal-menu" role="button" aria-expanded="false" aria-controls="horizontal-menu">
                            <i class="icon">
                                
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z" fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z" fill="currentColor"></path>
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
                    
                    <!-- Equipments -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('equipments*') ? 'active' : '' }}" 
                        aria-current="page" href="{{ url('/equipments') }}">
                            <i class="icon">
                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                                <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAE3UlEQVR4AcyUe0yTZxTGn14sRYpAoWilA4QRKMoSFd2c4mZmhGl2H7vBNNuixqH7Y5fMZVORGZO5ZTPiZrZVnXE6VidORTFmKMHrxMJEmSIUAiIVKm2hF/rdd9rRxQuDuWTJTr435217zvN7zznvVzn+Y/v/AqbuOJ84/uPK9JEa8K8ryJ2VYZ75sPH3zK9rf9KVHJ78d6ARAVlPFs3WZue/gcx81a0i05TsqNVJcvm6x1Key8nOtGR8+WulflVFzq0xgf2IAL1WU7js5TxTVtrY5qTcZUWGGfnhgURRgqzR7kUqfFg/KUz26bzUvEempddkbjxx0vjF8bmBmMAaERAbE4V3X38Gez57O3HxUzmb70tNsWYXfvQezwvqrLEajFErwfEC5A473s9Q4fPc1JkTDfE/B8QDa1hAvtms4MOjYwEZEvTxWFGwAN+vK9IX5E7f4OtzG5t6fegfYCGKwNSUeERHqGGMUkALRglQEoChAcWS/HFz04suLqNBljXj2cYbfWjpdlE4MFYXi9eeyMH4+BgkjQkLioarFKhrs6PL4YFapQTP8RIFB9bQgDlJlvJohVD20oTwzJk6BT481o6CsgbsPtsCuUwGhYIOSOndAwL8LIebbj+MCTFIGx8D0MEJwGPQhqyg12ZPmKL2YV9DJ35s9qLjejc6rFZ02p2DaaROO4bjMUqpRGKcBh29HlzudIAhIAFE+jn43AXINTdqBZHTitTYHqcbto4O9LtcEASBei0FfSBTkiToI1SQQ0Jrdz/iNGF4ICkOkeEqiAJNPRBE6zbAtA2HxgkDfKsCUgrPc+DoNBzHBXoKgWOx9ZcLBBERECd9tLkphu7rREMMWEHExfabcPs5iFQZaQef2wBOho1w9PRELX/QgDqbD26PDzzLQub3IdmgR3LWJDg8A8EqvIKE6QmRUCsVaLzWS63hkZGgxZjRaqqJyg/K33GLREaQsywDhpJbvAAjyaDVapE9dy4W5T2EJdMNeOvgZSzZewlqexesfhJ3izRcLWIj1bDecKHP64fEi8KgPrWQdlSyos/jKTy8dFalnGNALxFYOjkNC+roaCy6X4XLXQ5sa/Lhao8bVXVXcNRyFbaL9fBfa8UrpQdPnr3uuaCP1SBSraA2Ur/wpwVbZKqoyW1r79ypG61MNS/MRkKEDAqeIQgDjmHhpVY1dPWjq7UNdpsNfr+f5gDYXH7oYjR4dJzyzKsz0iYX7Dg/v+xce7Wjf6AZgxYEHLVcqinZdXztlvJql8/jhTEuDN8uSIbp+Uk0MAaQxOCQGRJmaehCYPgMg8n09m4vO+Qz7TxQD8ikUyvnV76ZN2VOdfELszFoQcCe4iJP+fplxUfqmlNWb6tcu7em0cXRTcjQR2HjvETEqghAs+HoJunoP3XplDhwN6/7F64s3Ww6cDbt2hnzD4N6d7kgIPTtyS0fOCs2vlNcXXt1wlrTkTXbK047NTIBs4yJ+GpBCpZP1eFpg4yrOmExldc0pHef2b0CTQe6QvlD+dsAoYDq74pdVVtXl1TVWicsX799zZrS3c7ahmahuua3XftPN01s3LdpsfPUzo5Q/HB+SEAowbLnkz7LvtKSY/X1yfvPXUkncGFrxaa/BhiKG84PCwgltlTu6j/9zSpr6PO9+H8EuBfBO2P/AAAA//9D0HFIAAAABklEQVQDAM4pOE/mkG/OAAAAAElFTkSuQmCC" x="0" y="0" width="24" height="24"/>
                            </svg>
                             </i>
                            <span class="item-name">Equipments</span>
                        </a>
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
                                <svg width="20" height="20" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Flask Body -->
                                    <path d="M80 20V70L35 145C29 155 36 168 48 168H152C164 168 171 155 165 145L120 70V20"
                                        stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>

                                    <!-- Flask Neck -->
                                    <path d="M70 20H130" stroke="currentColor" stroke-width="8" stroke-linecap="round"/>

                                    <!-- Liquid -->
                                    <path d="M55 125C70 118 82 130 100 130C118 130 130 118 145 125V145C145 149 142 152 138 152H62C58 152 55 149 55 145V125Z"
                                        fill="currentColor" opacity="0.25"/>

                                    <!-- Bubbles -->
                                    <circle cx="88" cy="102" r="6" fill="currentColor"/>
                                    <circle cx="112" cy="92" r="4" fill="currentColor"/>
                                    <circle cx="100" cy="112" r="3" fill="currentColor"/>
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
        