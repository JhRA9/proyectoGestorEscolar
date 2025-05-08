from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os

# Configuro el navegador para realizar las pruebas
driver = webdriver.Chrome()
driver.get("http://localhost/proyectoEscuela/login/index.php")  # Accedo a la página de inicio de sesión

# Creo una carpeta para guardar las capturas de pantalla
if not os.path.exists("Capturas de pantalla"):
    os.makedirs("Capturas de pantalla")

# Defino una función para tomar capturas de pantalla
def capturar_pantalla(nombre):
    driver.save_screenshot(f"Capturas de pantalla/{nombre}.png")

# Flujo 1: Inicio de sesión para usuarios autenticados
try:
    print("Iniciando sesión como usuario autenticado...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")  # Credenciales válidas
    driver.find_element(By.NAME, "password").send_keys("123")
    capturar_pantalla("flujo1_ingresando_datos_login")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)

    # Verifico si el usuario fue redirigido correctamente al dashboard
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar_pantalla("flujo1_login_exitoso")
    print("Flujo 1: Inicio de sesión - PASÓ")
except Exception as e:
    capturar_pantalla("flujo1_error")
    print(f"Flujo 1: Inicio de sesión - FALLÓ: {e}")
    driver.quit()
    exit()

# Flujo 2: Eliminar una materia existente
try:
    print("Probando eliminación de una materia existente...")
    driver.get("http://localhost/proyectoEscuela/admin/materias/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))

    # Selecciono el primer botón de eliminación disponible
    boton_eliminar = driver.find_element(By.XPATH, "//button[contains(@onclick, 'preguntar')]")
    boton_eliminar.click()

    # Confirmo la eliminación en el modal de SweetAlert
    WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.CLASS_NAME, "swal2-confirm"))).click()

    # Verifico que la materia desaparezca de la lista
    WebDriverWait(driver, 10).until_not(EC.presence_of_element_located((By.XPATH, "//td[contains(text(), 'Materia de Prueba')]")))
    capturar_pantalla("flujo2_materia_eliminada")
    print("Flujo 2: Eliminación de materia - PASÓ")
except Exception as e:
    capturar_pantalla("flujo2_error")
    print(f"Flujo 2: Eliminación de materia - FALLÓ: {e}")

# Flujo 3: Intento de eliminación por un usuario sin permisos
try:
    print("Probando eliminación de materia por un usuario sin permisos...")
    driver.get("http://localhost/proyectoEscuela/login/logout.php")  # Cierro sesión del administrador
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))

    # Inicio sesión con un usuario sin permisos
    driver.find_element(By.NAME, "email").send_keys("estudiante@gmail.com")  # Usuario sin permisos
    driver.find_element(By.NAME, "password").send_keys("123")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)

    # Intento acceder al botón de eliminación
    driver.get("http://localhost/proyectoEscuela/admin/materias/index.php")
    capturar_pantalla("flujo3_acceso_denegado")

    # Verifico si el botón de eliminación está presente
    botones_eliminar = driver.find_elements(By.XPATH, "//button[contains(@onclick, 'preguntar')]")
    if len(botones_eliminar) == 0:
        print("Flujo 3: Eliminación por usuario sin permisos - PASÓ: El usuario no tiene acceso al botón de eliminación.")
    else:
        print("Flujo 3: Eliminación por usuario sin permisos - FALLÓ: El usuario tiene acceso al botón de eliminación.")
except Exception as e:
    capturar_pantalla("flujo3_error")
    print(f"Flujo 3: Eliminación por usuario sin permisos - FALLÓ: {e}")

# Cierro el navegador después de realizar las pruebas
driver.quit()