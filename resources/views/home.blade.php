@extends('layouts.default')
@section('title', 'Home')

@section('content')

<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-10">
            <div class="card o-hidden border-0 shadow-lg mt-10">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="px-3 p-10">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Search For Any Article</h1>
                                    <p class="mb-4">Power your academic article search with Large Language Models! Our platform leverages advanced algorithms, such as LLAMA 2, to enhance your search by expanding key terms and providing feedback for more relevant articles.</p>
                                </div>
                                <form class="user" method="get" action="{{ url('/search') }}">
                                    @csrf
                                    @method('GET')
                                    <div class="form-group">
                                        <select name="subject" class="form-control form-control-user" style="height: inherit; padding: 1rem;">
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
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="query" class="form-control form-control-user"
                                        placeholder="Enter Search Keywords..." autocomplete="off">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Search
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection