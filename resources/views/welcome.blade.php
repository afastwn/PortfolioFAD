{{-- <!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Profile Page
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
      font-family: "Poppins", sans-serif;
    }
  </style>
 </head>
 <body class="bg-[#368466] min-h-screen flex items-center justify-center p-4">
  <div class="relative bg-white rounded-xl w-full max-w-[1200px] flex flex-col md:flex-row md:rounded-[20px] overflow-hidden" style="min-height: 700px">
   <!-- Left Sidebar -->
   <aside class="bg-[#368466] w-full md:w-60 flex flex-col justify-between py-6 px-6 rounded-t-xl md:rounded-l-xl md:rounded-tr-none relative">
    <div>
     <img alt="Logo of the institution with a shield and text" class="mb-10" height="40" src="https://storage.googleapis.com/a1aa/image/5f75949f-fca7-4ace-c131-d46e76ee75db.jpg" width="40"/>
     <nav class="flex flex-col space-y-6 text-white text-sm font-semibold">
      <a class="flex items-center space-x-3 opacity-70 hover:opacity-100 transition" href="#">
       <i class="fas fa-th-large text-lg">
       </i>
       <span>
        Home
       </span>
      </a>
      <a class="flex items-center space-x-3 opacity-70 hover:opacity-100 transition" href="#">
       <i class="far fa-folder text-lg">
       </i>
       <span>
        My Works
       </span>
      </a>
      <a class="flex items-center space-x-3 opacity-70 hover:opacity-100 transition" href="#">
       <i class="fas fa-expand text-lg">
       </i>
       <span>
        All Works
       </span>
      </a>
      <a class="flex items-center space-x-3 bg-white text-[#555555] rounded-full px-5 py-2 font-semibold relative" href="#">
       <i class="far fa-user text-lg">
       </i>
       <span>
        Profile
       </span>
       <div class="absolute -right-8 top-1/2 -translate-y-1/2 w-6 h-6 bg-white clip-path-custom" style="clip-path: polygon(0 50%, 100% 0, 100% 100%)">
       </div>
      </a>
     </nav>
    </div>
    <div class="w-full max-w-[140px]">
     <img alt="Illustration of a computer monitor with design tools, paintbrush, color palette, and coffee cup on a desk" class="w-full" height="140" src="https://storage.googleapis.com/a1aa/image/daa67c58-3327-4bdb-45b2-5b4ed8b00d27.jpg" width="140"/>
    </div>
   </aside>
   <!-- Main Content -->
   <main class="flex-1 p-8 md:p-12 flex flex-col">
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
     <h2 class="font-bold text-xs text-[#222222] tracking-wide">
      PROFILE
     </h2>
     <h1 class="font-extrabold text-4xl text-[#111111] flex items-center gap-2">
      HELLO!
      <span>
       👋
      </span>
     </h1>
    </header>
    <div class="flex flex-col md:flex-row md:space-x-8">
     <!-- Left Profile Card -->
     <section class="bg-[#eeeeee] rounded-xl shadow-md p-8 w-full md:w-2/3 relative">
      <h3 class="font-bold text-xs mb-6 text-[#222222]">
       PROFIL
      </h3>
      <div class="flex justify-center mb-8">
       <div aria-label="Profile picture placeholder, white circle on light gray background" class="rounded-full bg-white w-32 h-32">
       </div>
      </div>
      <table class="w-full text-sm text-[#222222] mb-8">
       <tbody>
        <tr class="border-b border-gray-300">
         <td class="pr-2 w-36 font-normal">
          STUDENT ID
         </td>
         <td class="w-2">
          :
         </td>
         <td class="pl-2">
          72220525
         </td>
        </tr>
        <tr class="border-b border-gray-300">
         <td class="pr-2 w-36 font-normal">
          FULL NAME
         </td>
         <td class="w-2">
          :
         </td>
         <td class="pl-2">
          Filistera Santoso
         </td>
        </tr>
        <tr class="border-b border-gray-300">
         <td class="pr-2 w-36 font-normal">
          PHONE NUMBER
         </td>
         <td class="w-2">
          :
         </td>
         <td class="pl-2">
          77777777
         </td>
        </tr>
        <tr class="border-b border-gray-300">
         <td class="pr-2 w-36 font-normal">
          ADDRESS
         </td>
         <td class="w-2">
          :
         </td>
         <td class="pl-2">
          Pati
         </td>
        </tr>
        <tr class="border-b border-gray-300">
         <td class="pr-2 w-36 font-normal">
          PERSONAL EMAIL
         </td>
         <td class="w-2">
          :
         </td>
         <td class="pl-2">
          @123
         </td>
        </tr>
        <tr>
         <td class="pr-2 w-36 font-normal">
          MOTIVATION
         </td>
         <td class="w-2">
          :
         </td>
         <td class="pl-2">
          i want....................
         </td>
        </tr>
       </tbody>
      </table>
      <div class="flex justify-center space-x-6 mb-6">
       <div class="bg-[#6ba9f7] w-20 h-6 rounded-sm">
       </div>
       <div class="bg-[#6ba9f7] w-20 h-6 rounded-sm">
       </div>
       <div class="bg-[#6ba9f7] w-20 h-6 rounded-sm">
       </div>
      </div>
      <button aria-label="Edit profile" class="absolute bottom-6 right-6 text-[#3a7ee0] hover:text-[#2a5ecb] transition">
       <i class="fas fa-pencil-alt">
       </i>
      </button>
     </section>
     <!-- Right Cards Container -->
     <div class="flex flex-col space-y-6 mt-8 md:mt-0 w-full md:w-1/3">
      <!-- Campus Activities Card -->
      <section class="bg-[#eeeeee] rounded-xl shadow-md p-6 relative text-xs text-[#222222]">
       <h4 class="font-bold mb-3">
        CAMPUS ACTIVITIES
       </h4>
       <ul class="space-y-2">
        <li class="flex items-center gap-2">
         <input checked="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" type="checkbox"/>
         <span>
          TEACHING ASSISTANT
         </span>
        </li>
        <li class="flex items-center gap-2">
         <input checked="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" type="checkbox"/>
         <span>
          LABORATORY VOLUNTEER
         </span>
        </li>
        <li class="flex items-center gap-2">
         <input checked="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" type="checkbox"/>
         <span>
          CAMPUS UNIT VOLUNTEER
         </span>
        </li>
        <li class="flex items-center gap-2">
         <input checked="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" type="checkbox"/>
         <span>
          CAMPUS EVENT COMMITTEE
         </span>
        </li>
       </ul>
       <button aria-label="Edit campus activities" class="absolute bottom-4 right-4 text-[#3a7ee0] hover:text-[#2a5ecb] transition">
        <i class="fas fa-pencil-alt">
        </i>
       </button>
      </section>
      <!-- Skills Card -->
      <section class="bg-[#eeeeee] rounded-xl shadow-md p-6 relative text-xs text-[#222222]">
       <h4 class="font-bold mb-3">
        SKILLS
       </h4>
       <ul class="space-y-2">
        <li class="flex items-center gap-2">
         <input checked="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" type="checkbox"/>
         <span>
          ADOBE PHOTOSHOP
         </span>
        </li>
        <li class="flex items-center gap-2">
         <input checked="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" type="checkbox"/>
         <span>
          COREL DRAW
         </span>
        </li>
        <li class="flex items-center gap-2">
         <input checked="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" type="checkbox"/>
         <span>
          ADOBE PHOTOSHOP
         </span>
        </li>
        <li class="flex items-center gap-2">
         <input checked="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" type="checkbox"/>
         <span>
          ADOBE ILLUSTRATOR
         </span>
        </li>
        <li class="flex items-center gap-2">
         <input checked="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" type="checkbox"/>
         <span>
          AUTOCAD
         </span>
        </li>
       </ul>
       <button aria-label="Edit skills" class="absolute bottom-4 right-4 text-[#3a7ee0] hover:text-[#2a5ecb] transition">
        <i class="fas fa-pencil-alt">
        </i>
       </button>
      </section>
      <!-- School Card -->
      <section class="bg-[#eeeeee] rounded-xl shadow-md p-6 relative text-xs text-[#222222]">
       <h4 class="font-bold mb-3">
        SCHOOL
       </h4>
       <table class="w-full text-xs text-[#222222]">
        <tbody>
         <tr class="border-b border-gray-300">
          <td class="pr-2 w-36 font-normal">
           SCHOOL ORIGIN
          </td>
          <td class="w-2">
           :
          </td>
          <td class="pl-2">
           72220525
          </td>
         </tr>
         <tr class="border-b border-gray-300">
          <td class="pr-2 w-36 font-normal">
           ADDRESS
          </td>
          <td class="w-2">
           :
          </td>
          <td class="pl-2">
           Filistera Santoso
          </td>
         </tr>
         <tr class="border-b border-gray-300">
          <td class="pr-2 w-36 font-normal">
           CITY/REGENCY
          </td>
          <td class="w-2">
           :
          </td>
          <td class="pl-2">
           Filistera Santoso
          </td>
         </tr>
         <tr>
          <td class="pr-2 w-36 font-normal">
           MAJOR
          </td>
          <td class="w-2">
           :
          </td>
          <td class="pl-2">
           Filistera Santoso
          </td>
         </tr>
        </tbody>
       </table>
       <button aria-label="Edit school" class="absolute bottom-4 right-4 text-[#3a7ee0] hover:text-[#2a5ecb] transition">
        <i class="fas fa-pencil-alt">
        </i>
       </button>
      </section>
     </div>
    </div>
   </main>
  </div>
 </body>
</html> --}}
