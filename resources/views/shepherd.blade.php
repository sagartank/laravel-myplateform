<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{ asset('plugins/shepherd/shepherd.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('plugins/shepherd/shepherd.css') }}">
    {{-- <script src="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/js/shepherd.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/css/shepherd.css" /> --}}
</head>

<body>
{{--     <button id="startTour">Start Tour</button>
    <script>
        document.getElementById('startTour').addEventListener('click', function() {
            // Initialize the Shepherd tour
            const tour = new Shepherd.Tour({
                defaultStepOptions: {
                    classes: 'shepherd-theme-arrows'
                }
            });

            // Add tour steps
            tour.addStep({
                id: 'step1',
                text: 'Welcome to the Shepherd.js demo!',
                attachTo: { element: '#startTour', on: 'bottom' },
                buttons: [
                    {
                        text: 'Next',
                        action: tour.next
                    }
                ]
            });

            tour.addStep({
                id: 'step2',
                text: '2222',
                attachTo: { element: 'body', on: 'center' },
                buttons: [
                    {
                        text: 'Next',
                        action: tour.next
                    }
                ]
            });

            tour.addStep({
                id: 'step3',
                text: '333.',
                attachTo: { element: 'body', on: 'center' },
                buttons: [
                    {
                        text: 'Done',
                        action: tour.complete
                    }
                ]
            });

            // Start the tour
            tour.start();
        });
    </script> --}}
    <script>
        const tour = new Shepherd.Tour({
            defaultStepOptions: {
                cancelIcon: {
                    enabled: true
                },
                classes: 'class-1 class-2',
                scrollTo: {
                    behavior: 'smooth',
                    block: 'center'
                }
            }
        });

        tour.addStep({
            title: 'Creating a Shepherd Tour',
            text: `Creating a Shepherd tour is easy. too!\Just create a \`Tour\` instance, and add as many steps as you want.`,
            attachTo: {
                element: '.hero-example',
                on: 'bottom'
            },
            buttons: [{
                    action() {
                        return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Back'
                },
                {
                    action() {
                        return this.next();
                    },
                    text: 'Next'
                }
            ],
            id: 'creating'
        });

        tour.addStep({
            title: 'Creating a Shepherd Tour 222',
            text: `Creating a Shepherd tour is easy. too!\Just create a \`Tour\` instance, and add as many steps as you want.`,
            attachTo: {
                element: '.hero-example',
                on: 'bottom'
            },
            buttons: [{
                    action() {
                        return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Back'
                },
                {
                    action() {
                        return this.next();
                    },
                    text: 'Next'
                }
            ],
            id: 'creating2'
        });

        tour.start();
    </script>
</body>

</html>
