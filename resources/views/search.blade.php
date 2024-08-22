@extends('layouts.default')
@section('title', 'Search Results')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script type="text/javascript">
    var app = angular.module('updateOrder', []);
    app.controller('updateOrderController', ['$scope', '$http', function($scope, $http) {
        $scope.docs = [];

        $scope.feedbackSearch = function(eid, title) {
            document.getElementById("search-results").innerHTML = "";

            subject = "{{ app('request')->input('subject') }}";
            query = "{{ app('request')->input('query') }}";
            console.log(title);
            console.log(subject);
            console.log(query);

            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() {
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
                    xmlHttp.responseText;

                    $scope.docs = JSON.parse(xmlHttp.responseText);

                    console.log(typeof $scope.docs);

                    // <tr ng-repeat="result in docs">
                    //         <td><a href="@{{ result.link[2].url }}" target="_blank">@{{ result.title }}</a> <br/>
                    //             <span class="badge badge-success">@{{ result.aggregationType }}</span>
                    //             <span class="badge badge-dark">@{{ result.affiliation[0].affilname }}</span>
                    //         </td>
                    //         <td>@{{ result.creator }}</td>
                    //         <td>@{{ result.coverDate }}</td>
                    //         <td>
                    //             <button class="btn btn-sm btn-primary" id="sidebarToggle" onclick="feedbackSearch('@{{ result.eid }}', '@{{ result.title }}')">Search</button>
                    //         </td>
                    //     </tr>

                    $scope.docs.forEach(function (doc) {
                        const tr = document.createElement("tr");
                        const td1 = document.createElement("td");
                        const span1 = document.createElement("span");
                        const span2 = document.createElement("span");
                        const br = document.createElement("br");
                        const td2 = document.createElement("td");
                        const td3 = document.createElement("td");
                        const td4 = document.createElement("td");

                        td1.innerText = doc.title;
                        td2.innerText = doc.creator;
                        td3.innerText = doc.coverDate;

                        span1.innerText = doc.aggregationType;
                        span1.classList.add("badge");
                        span1.classList.add("badge-success");
                        span2.innerText = doc.affiliation[0].affilname;
                        span2.classList.add("badge");
                        span2.classList.add("badge-dark");

                        td1.appendChild(br);
                        td1.appendChild(span1);
                        td1.appendChild(span2);

                        tr.appendChild(td1);
                        tr.appendChild(td2);
                        tr.appendChild(td3);

                        document.getElementById("search-results").appendChild(tr);
                    });

                }
                else if(xmlHttp.readyState == 4 && xmlHttp.status != 200) {
                // document.getElementById("abstract").innerHTML = "503: INTERNAL SERVER ERROR!";
            }
        };

        xmlHttp.onerror = function() {
            alert('Server Unreachable!');
        }

        var token = document.getElementsByName("_token")[0].value;

        url = "{{ $feedback_search_url }}";

        console.log(url);

        xmlHttp.open("GET", url+'?_token='+token+'&query='+query+'&subject='+subject+'&title='+title, true);
        xmlHttp.send();
        return false;

    }
}]);

</script>

<!-- Page Wrapper -->
<div id="wrapper" ng-app="updateOrder" ng-controller="updateOrderController">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form method="get" action="{{ url('/search') }}" class="d-none d-sm-inline-block form-inline mr-auto ml-auto my-2 my-md-0 mw-100 navbar-search">
                    @csrf
                    @method('GET')
                    <div class="input-group">
                        <select name="subject" class="form-control bg-light border-0" style="height: inherit; flex-grow: 2;">
                            <option value="">-- Select Subject --</option>
                            <option value="AGRI" @selected(app("request")->input('subject') == "AGRI")>Agricultural and Biological Sciences</option>
                            <option value="ARTS" @selected(app("request")->input('subject') == "ARTS")>Arts and Humanities</option>
                            <option value="BIOC" @selected(app("request")->input('subject') == "BIOC")>Biochemistry, Genetics and Molecular Biology</option>
                            <option value="BUSI" @selected(app("request")->input('subject') == "BUSI")>Business, Management and Accounting</option>
                            <option value="CENG" @selected(app("request")->input('subject') == "CENG")>Chemical Engineering</option>
                            <option value="CHEM" @selected(app("request")->input('subject') == "CHEM")>Chemistry</option>
                            <option value="COMP" @selected(app("request")->input('subject') == "COMP")>Computer Science</option>
                            <option value="DECI" @selected(app("request")->input('subject') == "DECI")>Decision Sciences</option>
                            <option value="DENT" @selected(app("request")->input('subject') == "DENT")>Dentistry</option>
                            <option value="EART" @selected(app("request")->input('subject') == "EART")>Earth and Planetary Sciences</option>
                            <option value="ECON" @selected(app("request")->input('subject') == "ECON")>Economics, Econometrics and Finance</option>
                            <option value="ENER" @selected(app("request")->input('subject') == "ENER")>Energy</option>
                            <option value="ENGI" @selected(app("request")->input('subject') == "ENGI")>Engineering</option>
                            <option value="ENVI" @selected(app("request")->input('subject') == "ENVI")>Environmental Science</option>
                            <option value="HEAL" @selected(app("request")->input('subject') == "HEAL")>Health Professions</option>
                            <option value="IMMU" @selected(app("request")->input('subject') == "IMMU")>Immunology and Microbiology</option>
                            <option value="MATE" @selected(app("request")->input('subject') == "MATE")>Materials Science</option>
                            <option value="MATH" @selected(app("request")->input('subject') == "MATH")>Mathematics</option>
                            <option value="MEDI" @selected(app("request")->input('subject') == "MEDI")>Medicine</option>
                            <option value="NEUR" @selected(app("request")->input('subject') == "NEUR")>Neuroscience</option>
                            <option value="NURS" @selected(app("request")->input('subject') == "NURS")>Nursing</option>
                            <option value="PHAR" @selected(app("request")->input('subject') == "PHAR")>Pharmacology, Toxicology and Pharmaceutics</option>
                            <option value="PHYS" @selected(app("request")->input('subject') == "PHYS")>Physics and Astronomy</option>
                            <option value="PSYC" @selected(app("request")->input('subject') == "PSYC")>Psychology</option>
                            <option value="SOCI" @selected(app("request")->input('subject') == "SOCI")>Social Sciences</option>
                            <option value="VETE" @selected(app("request")->input('subject') == "VETE")>Veterinary</option>
                            <option value="MULT" @selected(app("request")->input('subject') == "MULT")>Multidisciplinary</option>
                        </select>

                        <input type="text" name="query" class="form-control bg-light border-0 small" placeholder="Type keywords..."
                        aria-label="Search" aria-describedby="basic-addon2" value="{{ app('request')->input('query') }}" style="flex-grow: 5;" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-3" type="submit">
                                <i class="fas fa-search fa-sm"></i> &nbsp;Search
                            </button>
                        </div>
                    </div>
                </form>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Search results for "{{ app('request')->input('query') }}"</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author(s)</th>
                                        <th>Publisher</th>
                                        <th>Date Published</th>
                                        <th>Search</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                    <tr>
                                        <td><a href="{{ $result->link[2]->url }}" target="_blank">{{ $result->title }}</a> <br/>
                                            <span class="badge badge-success">{{ $result->aggregationType }}</span>
                                            <span class="badge badge-dark">{{ $result->affiliation[0]->affilname }}</span>
                                        </td>
                                        <td>{{ $result->creator }}</td>
                                        <td>{{ $result->publicationName }}</td>
                                        <td>{{ $result->coverDate }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" id="sidebarToggle" ng-click="feedbackSearch('{{ $result->eid }}', '{{ $result->title }}')">Search</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Virginia Polytechnic Institute and State University 2024</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-text mx-3">More Articles</div>
        </a>

        <!-- Divider -->
        <!-- <hr class="sidebar-divider my-0"> -->

        <div class="card shadow mb-4 mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">More results for "{{ app('request')->input('query') }}"</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author(s)</th>
                                <th>Date Published</th>
                            </tr>
                        </thead>
                        <tbody id="search-results">
                        <!-- <tr ng-repeat="result in docs">
                            <td><a href="@{{ result.link[2].url }}" target="_blank">@{{ result.title }}</a> <br/>
                                <span class="badge badge-success">@{{ result.aggregationType }}</span>
                                <span class="badge badge-dark">@{{ result.affiliation[0].affilname }}</span>
                            </td>
                            <td>@{{ result.creator }}</td>
                            <td>@{{ result.coverDate }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" id="sidebarToggle" onclick="feedbackSearch('@{{ result.eid }}', '@{{ result.title }}')">Search</button>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@endsection
