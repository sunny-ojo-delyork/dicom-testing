<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// authentication
Route::prefix('auth')->group(function(){
Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('complete-profile', [RegisterController::class, 'completeProfile'])->middleware('auth:sanctum');
});

//password reset
Route::post('/password/forgot', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/password/reset/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/password/reset', [NewPasswordController::class, 'store'])->name('password.update');

Route::post('/email/verification-notification', [VerifyEmailController::class, 'resend'])
->name('verification.send')->middleware('auth:sanctum');
Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])->name('verification.verify');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::get('dicom-web/studies', function () {
    $ohifDataSource = [
        [
            "00100020" => ["vr" => "LO", "Value" => ["M1"]],
            "00100010" => ["vr" => "PN", "Value" => [["Alphabetic" => "M1"]]],
            "00100030" => ["vr" => "DA"],
            "00100040" => ["vr" => "CS", "Value" => ["O"]],
            "00081030" => ["vr" => "LO", "Value" => ["General Static Scan + CT"]],
            "00080050" => ["vr" => "SH"],
            "0020000D" => ["vr" => "UI", "Value" => ["2.25.232704420736447710317909004159492840763"]],
            "00080020" => ["vr" => "DA", "Value" => ["20220915"]],
            "00080030" => ["vr" => "TM", "Value" => ["105557.469"]],
            "00200010" => ["vr" => "SH", "Value" => ["658"]],
            "00090010" => ["Value" => ["dedupped"], "vr" => "CS"],
            "00091011" => ["Value" => ["c44d2bc6b1afe2cdf57e7e84b37d54f73dd36a10d27723c7baf2a8ce15776d15"]],
            "00091012" => ["Value" => ["study"]],
            "00080061" => ["Value" => ["CT", "PT"], "vr" => "CS"],
            "00201208" => ["Value" => [10163], "vr" => "IS"],
            "00201206" => ["Value" => [2], "vr" => "IS"],
        ],
       
        // [
        //     "00100020" => ["vr" => "LO", "Value" => ["ACRIN-NSCLC-FDG-PET-042"]],
        //     "00100010" => ["vr" => "PN", "Value" => [["Alphabetic" => "ACRIN-NSCLC-FDG-PET-042"]]],
        //     "00100030" => ["vr" => "DA"],
        //     "00100040" => ["vr" => "CS", "Value" => ["M"]],
        //     "00120062" => ["vr" => "CS", "Value" => ["YES"]],
        //     "00120064" => [
        //         "vr" => "SQ",
        //         "Value" => [
        //             [
        //                 "00080100" => ["vr" => "SH", "Value" => ["113100"]],
        //                 "00080102" => ["vr" => "SH", "Value" => ["DCM"]],
        //                 "00080104" => ["vr" => "LO", "Value" => ["Basic Application Confidentiality Profile"]],
        //             ],
        //             [
        //                 "00080100" => ["vr" => "SH", "Value" => ["113101"]],
        //                 "00080102" => ["vr" => "SH", "Value" => ["DCM"]],
        //                 "00080104" => ["vr" => "LO", "Value" => ["Clean Pixel Data Option"]],
        //             ],
        //             // Add more items as needed
        //         ],
        //     ],
        //     // Add more studies as needed
        // ],
    ];

    return response()->json($ohifDataSource);
});


Route::get('dicom-web/studies/{id}/series', function($id){
 
    $data = [
        [
            "0020000D" => [
                "vr" => "UI",
                "Value" => [
                    "2.16.840.1.114362.1.11972228.22789312658.616067305.306.2",
                ],
            ],
            "0008103E" => [
                "vr" => "LO",
                "Value" => [
                    "Neck  1.0  B31s",
                ],
            ],
            "00200011" => [
                "vr" => "IS",
                "Value" => [
                    6,
                ],
            ],
            "0020000E" => [
                "Value" => [
                    "2.16.840.1.114362.1.11972228.22789312658.616067305.306.3",
                ],
            ],
            "00080060" => [
                "vr" => "CS",
                "Value" => [
                    "CT",
                ],
            ],
            "00080021" => [
                "vr" => "DA",
                "Value" => [
                    "20120507",
                ],
            ],
            "00080031" => [
                "vr" => "TM",
                "Value" => [
                    "132135.828000",
                ],
            ],
            "00080005" => [
                "vr" => "CS",
                "Value" => [
                    "ISO_IR 100",
                ],
            ],
            "00080070" => [
                "vr" => "LO",
                "Value" => [
                    "SIEMENS",
                ],
            ],
            "00080080" => [
                "vr" => "LO",
            ],
            "00080090" => [
                "vr" => "PN",
            ],
            "00081090" => [
                "vr" => "LO",
                "Value" => [
                    "Definition AS+",
                ],
            ],
            "00180015" => [
                "vr" => "CS",
                "Value" => [
                    "NECK",
                ],
            ],
            "00181030" => [
                "vr" => "LO",
                "Value" => [
                    "NECK",
                ],
            ],
            "00321060" => [
                "vr" => "LO",
                "Value" => [
                    "CT NECK SOFT TISSUE  W/ CONTR",
                ],
            ],
            "00090010" => [
                "Value" => [
                    "dedupped",
                ],
                "vr" => "CS",
            ],
            "00091011" => [
                "Value" => [
                    "a5d5ef0f9f0f6d40a5bd5d237e1cc24bca1c0f35af02db69e003556539a8d2f2",
                ],
            ],
            "00091012" => [
                "Value" => [
                    "series",
                ],
            ],
            "00201209" => [
                "vr" => "IS",
                "Value" => [
                    295,
                ],
            ],
        ],
    ];
    
    // Now you can use the $data array in your PHP code
    
     return response()->json($data, 200,[]);
});
Route::get('dicom-web/studies/{studyId}/series/{id}/metadata', function($id){
  

    $data = [
        [
            "00080013" => [
                "vr" => "TM",
                "Value" => ["123740.925"]
            ],
            "00080014" => [
                "vr" => "UI",
                "Value" => ["2.25.176605637453358727726590102203843764384"]
            ],
            "00080018" => [
                "Value" => ["2.25.179478223177027022014772769075050874231"]
            ],
            "00102201" => [
                "vr" => "LO",
                "Value" => ["Pferd"]
            ],
            "00102292" => [
                "vr" => "LO",
                "Value" => ["Hannoveraner"]
            ],
            "00180040" => [
                "vr" => "IS",
                "Value" => [60]
            ],
            "00181063" => [
                "vr" => "DS",
                "Value" => [16.17]
            ],
            "00200013" => [
                "vr" => "IS",
                "Value" => [0]
            ],
            "00200060" => [
                "vr" => "CS"
            ],
            "00280008" => [
                "vr" => "IS",
                "Value" => [3360]
            ],
            "00280009" => [
                "vr" => "AT",
                "Value" => ["00181063"]
            ],
            "00280301" => [
                "vr" => "CS",
                "Value" => ["YES"]
            ],
            "00280303" => [
                "vr" => "CS",
                "Value" => ["UNMODIFIED"]
            ],
            "00282110" => [
                "vr" => "CS",
                "Value" => ["01"]
            ],
            "7FE00010" => [
                "vr" => "OB",
                "BulkDataURI" => "https://server.dcmjs.org/dcm4chee-arc/aets/DCM4CHEE/rs/studies/1.2.840.113619.2.134.1762899950.15687.1075110464.566/series/1.2.840.113619.2.134.1762899950.15687.1075110464.567/instances/1.2.840.113619.2.134.1762899950.15687.1075110464.568"
            ],
            "00083002" => [
                "vr" => "UI",
                "Value" => ["1.2.840.10008.1.2.4.103"]
            ],
            "00090010" => [
                "Value" => ["dedupped"],
                "vr" => "CS"
            ],
            "00091010" => [
                "Value" => [
                    "99b96ec629620d9da70d4eb19aa7069f74aaad70a8ea03d05b7b07ebd0737201",
                    "d0b9038e670268fca4c186808fa92610c2f841df33ea1fd261c3bfc7968f755f",
                    "3eed66d6a2d5dc9f25acc62278a3c5ab2cc9ede41d08b1318f34da0b383a41dc",
                    "fcab3c75db6ad83fc95ed7145e41384afcce487e71fb9eca0005756152601f20"
                ]
            ],
            "0020000E" => [
                "Value" => ["2.25.15054212212536476297201250326674987992"]
            ],
            "00091011" => [
                "Value" => ["f67990da507433cef5097715228094acf2a17d7f45bcb6990ab2edf0c2652ab7"]
            ],
            "00091012" => [
                "Value" => ["instance"]
            ],
            "00100020" => [
                "vr" => "LO",
                "Value" => ["123"]
            ],
            "00100010" => [
                "vr" => "PN",
                "Value" => [
                    [
                        "Alphabetic" => "Horse"
                    ]
                ]
            ],
            "00100030" => [
                "vr" => "DA"
            ],
            "00100040" => [
                "vr" => "CS",
                "Value" => ["F"]
            ],
            "00120062" => [
                "vr" => "CS",
                "Value" => ["YES"]
            ],
            "00120064" => [
                "vr" => "SQ",
                "Value" => [
                    [
                        "00080100" => [
                            "vr" => "SH",
                            "Value" => ["113100"]
                        ],
                        "00080102" => [
                            "vr" => "SH",
                            "Value" => ["DCM"]
                        ],
                        "00080104" => [
                            "vr" => "LO",
                            "Value" => ["Basic Application Confidentiality Profile"]
                        ]
                    ],
                    [
                        "00080100" => [
                            "vr" => "SH",
                            "Value" => ["113106"]
                        ],
                        "00080102" => [
                            "vr" => "SH",
                            "Value" => ["DCM"]
                        ],
                        "00080104" => [
                            "vr" => "LO",
                            "Value" => ["Retain Longitudinal Temporal Information Full Dates Option"]
                        ]
                    ]
                ]
            ],
            "00080050" => [
                "vr" => "SH",
                "Value" => ["321"]
            ],
            "0020000D" => [
                "vr" => "UI",
                "Value" => ["2.25.96975534054447904995905761963464388233"]
            ],
            "00080020" => [
                "vr" => "DA",
                "Value" => ["20200723"]
            ],
            "00080030" => [
                "vr" => "TM",
                "Value" => ["092640.000"]
            ],
            "00200010" => [
                "vr" => "SH",
                "Value" => ["113"]
            ],
            "00200011" => [
                "vr" => "IS",
                "Value" => [123651829]
            ],
            "00080060" => [
                "vr" => "CS",
                "Value" => ["OT"]
            ],
            "00080021" => [
                "vr" => "DA",
                "Value" => ["20200723"]
            ],
            "00080031" => [
                "vr" => "TM",
                "Value" => ["123651.829"]
            ],
            "00080005" => [
                "vr" => "CS",
                "Value" => ["ISO_IR 100"]
            ],
            "00080070" => [
                "vr" => "LO",
                "Value" => ["ESCAPE"]
            ],
            "00080080" => [
                "vr" => "LO",
                "Value" => ["REMOVED"]
            ],
            "00080090" => [
                "vr" => "PN"
            ],
            "00081010" => [
                "vr" => "SH",
                "Value" => ["REMOVED"]
            ],
            "00081090" => [
                "vr" => "LO",
                "Value" => ["CX-PRIME"]
            ],
            "00080008" => [
                "vr" => "CS",
                "Value" => ["DERIVED\\SECONDARY"]
            ],
            "00080012" => [
                "vr" => "DA",
                "Value" => ["20200723"]
            ],
            "00080016" => [
                "vr" => "UI",
                "Value" => ["1.2.840.10008.5.1.4.1.1.7.4"]
            ],
            "00080064" => [
                "vr" => "CS",
                "Value" => ["WSD"]
            ],
            "00181016" => [
                "vr" => "LO",
                "Value" => ["caresyntax GmbH"]
            ],
            "00280002" => [
                "vr" => "US",
                "Value" => [3]
            ],
            "00280004" => [
                "vr" => "CS",
                "Value" => ["YBR_PARTIAL_420"]
            ],
            "00280006" => [
                "vr" => "US",
                "Value" => [0]
            ],
            "00280010" => [
                "vr" => "US",
                "Value" => [1080]
            ],
            "00280011" => [
                "vr" => "US",
                "Value" => [1920]
            ],
            "00280100" => [
                "vr" => "US",
                "Value" => [8]
            ],
            "00280101" => [
                "vr" => "US",
                "Value" => [8]
            ],
            "00280102" => [
                "vr" => "US",
                "Value" => [7]
            ],
            "00280103" => [
                "vr" => "US",
                "Value" => [0]
            ],
            "00200020" => [
                "vr" => "CS"
            ]
        ]
    ];
    
   
    
     return response()->json($data, 200,[]);
});


