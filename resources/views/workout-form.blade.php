<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Should I Work Out Today?</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <!-- <script src="https://js.sentry-cdn.com/52a79193e886a513804f6ba4b19e00a2.min.js" crossorigin="anonymous"></script> -->
    <script src="https://browser.sentry-cdn.com/7.97.0/bundle.tracing.replay.min.js" integrity="sha384-a3Fv3FyhmLl3QhFc7s4Yz61A8Y9ZtdXUt0qkuLyTiS8QaFKGAcbTSwMOkKvYEUgD" crossorigin="anonymous"></script>
    <script>
  Sentry.init({
    dsn: 'https://52a79193e886a513804f6ba4b19e00a2@o4509052553592832.ingest.us.sentry.io/4509056663486464',
    integrations: [
      new Sentry.BrowserTracing(),
      new Sentry.Replay(),
    ],
    tracesSampleRate: 1.0,
    replaysSessionSampleRate: 1.0,
    replaysOnErrorSampleRate: 1.0,
  });
</script>


</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
        <h1 class="text-xl font-bold mb-4 text-center">Should I Work Out Today?</h1>

        <div id="response" class="text-green-600 text-center mb-2"></div>
        <div id="errors" class="text-red-600 text-center mb-2"></div>

        <form id="workout-form" class="space-y-4">
            @csrf

            <div>
                <label for="soreness" class="block font-medium">How sore are you? (1–10)</label>
                <input type="number" id="soreness" name="soreness" min="1" max="10" required
                       class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label for="sleep" class="block font-medium">How many hours did you sleep?</label>
                <input type="number" step="0.1" id="sleep" name="sleep" min="0" max="24" required
                       class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <p class="font-medium">Do you feel like working out?</p>
                <label class="inline-flex items-center mr-4">
                    <input type="radio" name="feel_like" value="yes" required class="mr-2"> Yes
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="feel_like" value="no" required class="mr-2"> No
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white rounded py-2 hover:bg-blue-700 transition">
                Submit
            </button>
        </form>
    </div>

    <script>
        document.getElementById('workout-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            const responseDiv = document.getElementById('response');
            const errorsDiv = document.getElementById('errors');
            responseDiv.innerHTML = '';
            errorsDiv.innerHTML = '';

            try {
                const response = await fetch('/submit', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    const errorMessages = Object.values(errorData.errors).flat();
                    errorsDiv.innerHTML = errorMessages.map(msg => `<div>${msg}</div>`).join('');
                    return;
                }

                const data = await response.json();
                responseDiv.textContent = data.message;
            } catch (error) {
                errorsDiv.textContent = 'Wrong Answer! Go Workout!';
            }
        });
    </script>
</body>
</html>


