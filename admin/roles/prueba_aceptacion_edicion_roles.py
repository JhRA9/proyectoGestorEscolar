from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os

# Configuración inicial del navegador
driver = webdriver.Chrome()
driver.maximize_window()
driver.get("http://localhost/proyectoEscuela/login/index.php")

# Crear carpeta para capturas de pantalla
if not os.path.exists("Capturas de pantalla"):
    os.makedirs("Capturas de pantalla")

# Función para capturar pantallas
def capturar(nombre):
    driver.save_screenshot(f"Capturas de pantalla/{nombre}.png")

# Flujo 1: Inicio de sesión como administrador
try:
    print("Iniciando sesión como administrador...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")
    driver.find_element(By.NAME, "password").send_keys("123")
    capturar("login_datos_ingresados")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar("login_exitoso")
    print("Inicio de sesión completado con éxito.")
except Exception as e:
    capturar("login_error")
    print(f"Error durante el inicio de sesión: {e}")
    driver.quit()
    exit()

# Flujo 2: Acceso a la funcionalidad de edición de roles
try:
    print("Accediendo a la funcionalidad de edición de roles...")
    driver.get("http://localhost/proyectoEscuela/admin/roles/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))

    # Selecciono el botón de "Editar" para el primer rol disponible
    boton_editar = driver.find_element(By.XPATH, "//a[contains(@href, 'edit.php?id=')]")
    boton_editar.click()

    # Verifico que el formulario de edición esté visible
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "nombre_rol")))
    capturar("formulario_edicion")
    print("Flujo 2: Acceso a la funcionalidad de edición de roles - PASÓ")
except Exception as e:
    capturar("error_acceso_edicion")
    print(f"Flujo 2: Acceso a la funcionalidad de edición de roles - FALLÓ: {e}")

# Flujo 3: Modificación de datos del rol
try:
    print("Modificando los datos del rol...")
    nombre_rol = driver.find_element(By.NAME, "nombre_rol")
    descripcion_rol = driver.find_element(By.NAME, "descripcion_rol")

    # Modifico el nombre y la descripción del rol
    nombre_rol.clear()
    nombre_rol.send_keys("Rol Editado")
    descripcion_rol.clear()
    descripcion_rol.send_keys("Descripción actualizada del rol.")
    capturar("datos_modificados")

    # Guardo los cambios
    driver.find_element(By.XPATH, "//button[contains(text(), 'Guardar')]").click()

    # Verifico el mensaje de éxito
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CLASS_NAME, "alert-success")))
    capturar("rol_actualizado")
    print("Flujo 3: Modificación de datos del rol - PASÓ")
except Exception as e:
    capturar("error_modificacion_datos")
    print(f"Flujo 3: Modificación de datos del rol - FALLÓ: {e}")

# Finalizo la prueba cerrando el navegador
driver.quit()