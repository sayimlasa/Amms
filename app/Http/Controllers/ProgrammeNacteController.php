<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Programme;
use Illuminate\Http\Request;
use App\Models\ProgrammeNacte;
use App\Models\ApplicationLevel;

class ProgrammeNacteController extends Controller
{
    //arusha campus
    public function arusha()
    {
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
        $nacteprogram = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        return view('Admission.Applicants.nactevet.arusha-programme', compact('nacteprogram'));
    }

    public function storeArusha(Request $request)
    {
        // API key and endpoint URL
        $api_key = "xyac3f719fe7f91e-061eae04e3daa663b1d8c499d8af5fef82484f823aabb0361ac75f3f4040ddf2-00b40713e6379090f3c9f7be5ad9885c2f4cde3b";
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/institutions/{$api_key}";

        // Initialize cURL session
        $curl = curl_init();

        // cURL options setup
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        // Execute cURL request
        $response = curl_exec($curl);

        // Get the HTTP status code
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($curl);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
            if (isset($data['params']) && is_array($data['params'])) {
                foreach ($data['params'] as $program) {
                    ProgrammeNacte::updateOrCreate(
                        ['program_id' => $program['programe_id']],
                        [
                            'campus_id' => $arushaCampus,
                            'program_name' => $program['programme'] ?? 'N/A',
                        ]
                    );
                }

                return redirect()->route('programme.arusha')->with('success', 'Institutions data has been successfully stored.');
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API response or empty data.'
            ], 500);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Request failed with status code $httpCode."
            ], $httpCode);
        }
    }
    public function editArusha($id)
    {
        $program = ProgrammeNacte::findOrFail($id);
        $levels = ApplicationLevel::all();
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
        //$programmeIaa=Programme::whereIn('application_level_id', $levels->pluck('id'))->get();
        return view('Admission.Applicants.nactevet.edit-arushaprogramme', compact('program', 'levels'));
    }


    public function getProgrammesByLevel($levelId)
    {
        $programmes = Programme::where('application_level_id', $levelId)->get(['id', 'name']);
        return response()->json($programmes);
    }

    public function updateArusha(Request $request, $id)
    {
        $request->validate([
            'nta' => 'required|exists:application_levels,id',
            'arusha_program' => 'required|exists:programmes,id',
            'arusha_program_id' => 'required',

        ]);

        $program = ProgrammeNacte::findOrFail($id);
        $program->nta = $request->nta;
        $program->iaa_program = $request->arusha_program;
        $program->iaa_program_id = $request->arusha_program_id;

        $program->save();

        return redirect()->route('programme.arusha')->with('success', 'Arusha programme updated successfully!');
    }

    //dar campus
    public function dar()
    {
        $arushaCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        $nacteprogramdar = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        return view('Admission.Applicants.nactevet.dar-programme', compact('nacteprogramdar'));
    }

    public function storeDar(Request $request)
    {
        // API key and endpoint URL
        $api_key = "ST69be44b1dbd30e-9434acdf316697abbd26fc5c17ffc7b785391c2f7cdbcae58663d3679e721dd3-9bd8a8a6af9dd230ac016018faac70c6c1359d02";
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/institutions/{$api_key}";

        // Initialize cURL session
        $curl = curl_init();

        // cURL options setup
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        // Execute cURL request
        $response = curl_exec($curl);

        // Get the HTTP status code
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($curl);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            $arushaCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
            if (isset($data['params']) && is_array($data['params'])) {
                foreach ($data['params'] as $program) {
                    ProgrammeNacte::Create(
                        [
                            'program_id' => $program['programe_id'],
                            'campus_id' => $arushaCampus,
                            'program_name' => $program['programme'] ?? 'N/A',
                        ]
                    );
                }

                return redirect()->route('programme.dar')->with('success', 'Institutions data has been successfully stored.');
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API response or empty data.'
            ], 500);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Request failed with status code $httpCode."
            ], $httpCode);
        }
    }
    public function editDar($id)
    {
        $program = ProgrammeNacte::findOrFail($id);
        $levels = ApplicationLevel::all();
        //$programmeIaa=Programme::whereIn('application_level_id', $levels->pluck('id'))->get();
        return view('Admission.Applicants.nactevet.edit-darprogramme', compact('program', 'levels'));
    }

    public function updateDar(Request $request, $id)
    {
        $request->validate([
            'nta' => 'required|exists:application_levels,id',
            'dar_program' => 'required|exists:programmes,id',
            'dar_program_id' => 'required',

        ]);

        $program = ProgrammeNacte::findOrFail($id);
        $program->nta = $request->nta;
        $program->iaa_program = $request->dar_program;
        $program->iaa_program_id = $request->dar_program_id;
        $program->save();

        return redirect()->route('programme.dar')->with('success', 'Dar programme updated successfully!');
    }
    //babati campus
    public function babati()
    {
        $arushaCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();
        $nacteprogrambabati = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        //dd($nacteprogrambabati);
        return view('Admission.Applicants.nactevet.babati-programme', compact('nacteprogrambabati'));
    }

    public function storeBabati(Request $request)
    {
        // API key and endpoint URL
        $api_key = "EFcfa6d838bb1f0e-43053663806c3f183f9724a0f3a14208c2f64d01feba63248dd744b423eaa8bb-f52e132e63e45690fdba862823408398c05dcb06";
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/institutions/{$api_key}";

        // Initialize cURL session
        $curl = curl_init();

        // cURL options setup
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        // Execute cURL request
        $response = curl_exec($curl);

        // Get the HTTP status code
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($curl);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            $arushaCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();
            if (isset($data['params']) && is_array($data['params'])) {
                foreach ($data['params'] as $program) {
                    ProgrammeNacte::Create(
                        [
                            'program_id' => $program['programe_id'],
                            'campus_id' => $arushaCampus,
                            'program_name' => $program['programme'] ?? 'N/A',
                        ]
                    );
                }

                return redirect()->route('programme.babati')->with('success', 'Institutions data has been successfully stored.');
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API response or empty data.'
            ], 500);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Request failed with status code $httpCode."
            ], $httpCode);
        }
    }
    public function editBabati($id)
    {
        $program = ProgrammeNacte::findOrFail($id);
        $levels = ApplicationLevel::all();
        //$programmeIaa=Programme::whereIn('application_level_id', $levels->pluck('id'))->get();
        return view('Admission.Applicants.nactevet.edit-babatiprogramme', compact('program', 'levels'));
    }
    public function updateBabati(Request $request, $id)
    {
        $request->validate([
            'nta' => 'required|exists:application_levels,id',
            'babati_program' => 'required|exists:programmes,id',
            'babati_program_id' => 'required',

        ]);

        $program = ProgrammeNacte::findOrFail($id);
        $program->nta = $request->nta;
        $program->iaa_program = $request->babati_program;
        $program->iaa_program_id = $request->babati_program_id;
        $program->save();

        return redirect()->route('programme.babati')->with('success', 'Babati programme updated successfully!');
    }

    //songea campus
    public function songea()
    {
        $arushaCampus = Campus::where('name', 'like', '%songea%')->pluck('id')->first();
        $nacteprogramsongea = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        return view('Admission.Applicants.nactevet.songea-programme', compact('nacteprogramsongea'));
    }

    public function storesongea(Request $request)
    {
        // API key and endpoint URL
        $api_key = "yz18aa7390eca704-1e2decc472daae4b96e109325b2e6650155743b57d604aae13277efc5a445dff-9a4a44233c070afe16b2cde4b27bee4cfa14fabb";
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/institutions/{$api_key}";

        // Initialize cURL session
        $curl = curl_init();

        // cURL options setup
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        // Execute cURL request
        $response = curl_exec($curl);

        // Get the HTTP status code
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($curl);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            $arushaCampus = Campus::where('name', 'like', '%songea%')->pluck('id')->first();
            if (isset($data['params']) && is_array($data['params'])) {
                foreach ($data['params'] as $program) {
                    ProgrammeNacte::Create(
                        [
                            'program_id' => $program['programe_id'],
                            'campus_id' => $arushaCampus,
                            'program_name' => $program['programme'] ?? 'N/A',
                        ]
                    );
                }

                return redirect()->route('programme.songea')->with('success', 'Institutions data has been successfully stored.');
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API response or empty data.'
            ], 500);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Request failed with status code $httpCode."
            ], $httpCode);
        }
    }

    public function editsongea($id)
    {
        $program = ProgrammeNacte::findOrFail($id);
        $levels = ApplicationLevel::all();
        //$programmeIaa=Programme::whereIn('application_level_id', $levels->pluck('id'))->get();
        return view('Admission.Applicants.nactevet.edit-songeaprogramme', compact('program', 'levels'));
    }


    public function updatesongea(Request $request, $id)
    {
        $request->validate([
            'nta' => 'required|exists:application_levels,id',
            'songea_program' => 'required|exists:programmes,id',
            'songea_program_id' => 'required',

        ]);
        $program = ProgrammeNacte::findOrFail($id);
        $program->nta = $request->nta;
        $program->iaa_program = $request->songea_program;
        $program->iaa_program_id = $request->songea_program_id;
        $program->save();

        return redirect()->route('programme.songea')->with('success', 'songea programme updated successfully!');
    }
    //dodoma campus
    public function dodoma()
    {
        $arushaCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first();
        $nacteprogramdodoma = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        return view('Admission.Applicants.nactevet.dodoma-programme', compact('nacteprogramdodoma'));
    }

    public function storedodoma(Request $request)
    {
        // API key and endpoint URL
        $api_key = "xy09912db0211c7f-ac2ddbb8313851db2b93f363862849d3c8b54e419192dceca6f36cd56a90c5f2-460ab86aa02dfefac619860affe01616fa652b08";
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/institutions/{$api_key}";

        // Initialize cURL session
        $curl = curl_init();

        // cURL options setup
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        // Execute cURL request
        $response = curl_exec($curl);

        // Get the HTTP status code
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($curl);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            $arushaCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first();
            if (isset($data['params']) && is_array($data['params'])) {
                foreach ($data['params'] as $program) {
                    ProgrammeNacte::Create(
                        [
                            'program_id' => $program['programe_id'],
                            'campus_id' => $arushaCampus,
                            'program_name' => $program['programme'] ?? 'N/A',
                        ]
                    );
                }

                return redirect()->route('programme.dodoma')->with('success', 'Institutions data has been successfully stored.');
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API response or empty data.'
            ], 500);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Request failed with status code $httpCode."
            ], $httpCode);
        }
    }
    public function editdodoma($id)
    {
        $program = ProgrammeNacte::findOrFail($id);
        $levels = ApplicationLevel::all();
        //$programmeIaa=Programme::whereIn('application_level_id', $levels->pluck('id'))->get();
        return view('Admission.Applicants.nactevet.edit-dodomaprogramme', compact('program', 'levels'));
    }


    public function updatedodoma(Request $request, $id)
    {
        $request->validate([
            'nta' => 'required|exists:application_levels,id',
            'dodoma_program' => 'required|exists:programmes,id',
            'dodoma_program_id' => 'required',

        ]);

        $program = ProgrammeNacte::findOrFail($id);
        $program->nta = $request->nta;
        $program->iaa_program = $request->dodoma_program;
        $program->iaa_program_id = $request->dodoma_program_id;
        $program->save();

        return redirect()->route('programme.dodoma')->with('success', 'dodoma programme updated successfully!');
    }
}
