<?php
session_start();

include 'koneksi/mysql_conection.php';

$id_user = null;
$user = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id_user = $id;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE Id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    if ($user) {
        $user['TanggalLahir'] = date('d-m-Y', strtotime($user['TanggalLahir']));
    }

    if (!$user) {
        $user = null;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $tgl_lahir = $_POST['tgl_lahir'];
        $pendidikan = $_POST['pendidikan'];

        $dateTime = DateTime::createFromFormat('d-m-Y', $tgl_lahir);
        if ($dateTime) {
            $formattedDate = $dateTime->format('Y-m-d');
        } else {
            die("Format tanggal tidak valid.");
        }

        $stmt = $pdo->prepare("UPDATE users SET Nama = ?, Email = ?, TanggalLahir = ?, Pendidikan = ? WHERE Id = ?");
        $stmt->execute([$nama, $email, $formattedDate, $pendidikan, $id]);

        header('Location: index.php');
        exit;
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $tgl_lahir = $_POST['tgl_lahir'];
        $pendidikan = $_POST['pendidikan'];

        $dateTime = DateTime::createFromFormat('d-m-Y', $tgl_lahir);
        if ($dateTime) {
            $formattedDate = $dateTime->format('Y-m-d');
        } else {
            die("Format tanggal tidak valid.");
        }

        $stmt = $pdo->prepare("INSERT INTO users (Nama, Email, TanggalLahir, Pendidikan) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama, $email, $formattedDate, $pendidikan]);

        header('Location: index.php');
        exit;
    }
}

?>

<?php include 'partials/start.html' ?>

<section>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <div class="flex justify-start items-center gap-2">
                    <a href="index.php" class="p-1.5 hover:bg-slate-900 hover:text-white rounded-full">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        <?= $id_user !== null ? 'Sunting User' : 'Buat User' ?>
                    </h1>
                </div>
                <form class="space-y-4 md:space-y-6" method="POST">
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="w-full">
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="nama" id="nama" value="<?= isset($user) ? htmlspecialchars($user['Nama'], ENT_QUOTES) : '' ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan Nama Lengkap" required>
                        </div>
                        <div class="w-full">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" value="<?= isset($user) ? htmlspecialchars($user['Email'], ENT_QUOTES) : '' ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan Email" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Lahir</label>
                            <div class="relative max-w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input id="datepicker-format" datepicker datepicker-format="dd-mm-yyyy" type="text" name="tgl_lahir" value="<?= isset($user) ? htmlspecialchars($user['TanggalLahir'], ENT_QUOTES) : '' ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pilih Tanggal">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="pendidikan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pendidikan</label>
                            <input type="text" name="pendidikan" id="pendidikan" value="<?= isset($user) ? htmlspecialchars($user['Pendidikan'], ENT_QUOTES) : '' ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan Pendidikan" required>
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        <?= $id_user !== null ? 'Sunting User' : 'Tambah User' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'partials/end.html' ?>