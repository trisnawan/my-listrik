# fungsi untuk menampilkan menu
def tampilkan_menu():
    print("\n=== MENU ===")
    print("1. Input Angka")
    print("2. Sorting Angka")
    print("3. Searching Angka")
    print("4. Keluar")
    return input("Pilih menu (1-4): ")

# fungsi untuk input angka ke dalam global array
def input_angka():
    global angka_list
    angka_list.clear()
    n = int(input("Masukkan jumlah angka: "))
    for i in range(n):
        angka = int(input(f"Angka ke-{i+1}: "))
        angka_list.append(angka)
    print("Data berhasil dimasukkan.")

# fungsi untuk sorting data dengan quick search
def quicksort(arr):
    if len(arr) <= 1:
        return arr
    pivot = arr[0] # memilih pivot data
    left = [x for x in arr[1:] if x <= pivot] # partisi ke left, dengan rekursi (perulangan)
    right = [x for x in arr[1:] if x > pivot] # partisi ke right, dengan rekursi (perulangan)
    return quicksort(left) + [pivot] + quicksort(right) # gabung array

# fungsi untuk searching binary search
def binary_search(arr, target):
    left = 0
    right = len(arr) - 1
    while left <= right:
        mid = (left + right) // 2
        if arr[mid] == target:
            return True
        elif arr[mid] < target:
            left = mid + 1
        else:
            right = mid - 1
    return False

# Data global
angka_list = []

# Program utama
while True:
    pilihan = tampilkan_menu()
    if pilihan == '1':
        input_angka()
    elif pilihan == '2':
        if not angka_list:
            print("Data kosong. Silakan input angka terlebih dahulu.")
        else:
            angka_list = quicksort(angka_list)
            print("Hasil sorting:", angka_list)
    elif pilihan == '3':
        if not angka_list:
            print("Data kosong. Silakan input angka terlebih dahulu.")
        else:
            cari = int(input("Masukkan angka yang ingin dicari: "))
            ditemukan = binary_search(angka_list, cari)
            if ditemukan:
                print("Angka ditemukan.")
            else:
                print("Angka tidak ditemukan.")
    elif pilihan == '4':
        print("Terima kasih. Program selesai.")
        break
    else:
        print("Pilihan tidak valid. Silakan coba lagi.")
