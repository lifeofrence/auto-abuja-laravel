@extends('layouts.main')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0"
        style="background-image: url('{{ asset("img/carousel-bg-2.jpg") }}');">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Frequently Asked Questions</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- FAQ Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="mb-4">Frequently Asked Questions (FAQ)</h1>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    Why is regular car maintenance important?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Regular car maintenance helps prevent costly repairs, ensures your vehicle runs
                                    efficiently, improves safety, and extends the lifespan of your car.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    What Should I Do If I Get A Flat Tyre?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Pull over safely, turn on hazard lights, use a jack to lift the vehicle, remove the
                                    flat tire, and replace it with your spare. If you're unsure, contact a tow truck
                                    operator through our platform.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    Do I need to pay any dealers before seeing the vehicles?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    No, you should never pay before inspecting a vehicle. Reputable dealers on our
                                    platform allow you to view vehicles before making any payment commitments.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    How often should I change my car's oil?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Most vehicles require an oil change every 5,000 to 7,500 kilometers, but check your
                                    owner's manual for specific recommendations for your vehicle.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    What are the most common maintenance tasks?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Common tasks include oil changes, tire rotations, brake inspections, fluid checks,
                                    air filter replacements, and battery maintenance.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading6">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                    How often should I have my brakes checked?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Have your brakes inspected at least once a year or whenever you notice unusual
                                    sounds, vibrations, or reduced braking performance.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading7">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                    How often should I check my tire pressure?
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Check your tire pressure at least once a month and before long trips. Proper tire
                                    pressure improves fuel efficiency and safety.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading8">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                    What is tire rotation and why is it important?
                                </button>
                            </h2>
                            <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Tire rotation involves moving tires to different positions on your vehicle to ensure
                                    even wear, extending tire life and improving performance.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading9">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                    When should I replace my tires?
                                </button>
                            </h2>
                            <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Replace tires when tread depth is below 2mm, when you see visible damage, or after 6
                                    years regardless of wear. Use the penny test to check tread depth.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading10">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                                    When should I check and top off my car's fluids?
                                </button>
                            </h2>
                            <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Check fluids (oil, coolant, brake fluid, power steering fluid) monthly and top off
                                    as needed. Always use the correct fluid type for your vehicle.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading11">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                    What does the "check engine" light indicate?
                                </button>
                            </h2>
                            <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    The check engine light indicates a potential issue with your engine or emissions
                                    system. Have it diagnosed by a mechanic as soon as possible using our platform.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading12">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                    How do I know which parts my car needs?
                                </button>
                            </h2>
                            <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Consult your owner's manual, use our platform to connect with auto parts dealers, or
                                    ask a trusted mechanic for recommendations based on your vehicle's make and model.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading13">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                                    Can I use aftermarket parts?
                                </button>
                            </h2>
                            <div id="collapse13" class="accordion-collapse collapse" aria-labelledby="heading13"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Yes, quality aftermarket parts can be a cost-effective alternative to OEM parts.
                                    Ensure they meet industry standards and are compatible with your vehicle.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading14">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse14" aria-expanded="false" aria-controls="collapse14">
                                    What is a timing belt and when should it be replaced?
                                </button>
                            </h2>
                            <div id="collapse14" class="accordion-collapse collapse" aria-labelledby="heading14"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    A timing belt synchronizes engine components. Replace it every 60,000-100,000 km as
                                    recommended by your manufacturer to prevent engine damage.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading15">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse15" aria-expanded="false" aria-controls="collapse15">
                                    When should I replace my car's battery?
                                </button>
                            </h2>
                            <div id="collapse15" class="accordion-collapse collapse" aria-labelledby="heading15"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Most car batteries last 3-5 years. Replace if you experience slow engine cranking,
                                    dimming lights, or the battery is over 4 years old.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading16">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
                                    Can I perform basic car maintenance myself?
                                </button>
                            </h2>
                            <div id="collapse16" class="accordion-collapse collapse" aria-labelledby="heading16"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Yes! Basic tasks like checking fluids, changing air filters, and monitoring tire
                                    pressure can be done at home. For complex repairs, use our platform to find
                                    qualified mechanics.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading17">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
                                    How do I improve my car's fuel economy?
                                </button>
                            </h2>
                            <div id="collapse17" class="accordion-collapse collapse" aria-labelledby="heading17"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Maintain proper tire pressure, avoid aggressive driving, reduce excess weight, keep
                                    up with regular maintenance, and use the recommended grade of motor oil.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading18">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse18" aria-expanded="false" aria-controls="collapse18">
                                    What should I do if I hear a strange noise from my car?
                                </button>
                            </h2>
                            <div id="collapse18" class="accordion-collapse collapse" aria-labelledby="heading18"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body text-start">
                                    Don't ignore strange noises. They often indicate mechanical issues. Use our platform
                                    to find a trusted mechanic who can diagnose and fix the problem promptly.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ End -->

@endsection