from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os
from selenium.webdriver.common.keys import Keys

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

# Flujo 2: Acceso a la funcionalidad de búsqueda de usuario
try:
    print("Accediendo a la funcionalidad de búsqueda de usuario...")
    driver.get("http://localhost/proyectoEscuela/admin/usuarios/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))
    capturar("usuarios_cargados")
    print("Flujo 2: Acceso a la funcionalidad de búsqueda de usuario - PASÓ")
except Exception as e:
    capturar("error_acceso_busqueda")
    print(f"Flujo 2: Acceso a la funcionalidad de búsqueda de usuario - FALLÓ: {e}")

# Flujo 3: Realizar una búsqueda válida
try:
    print("Realizando una búsqueda válida...")
    campo_busqueda = driver.find_element(By.XPATH, "//input[@type='search']")
    campo_busqueda.send_keys("admin")  # Buscar por nombre o correo
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, "//table[@id='example1']/tbody/tr")))
    capturar("busqueda_valida")

    # Verificar que los resultados coincidan con el término de búsqueda
    filas = driver.find_elements(By.XPATH, "//table[@id='example1']/tbody/tr")
    resultados = [fila.text for fila in filas]
    if any("admin" in resultado.lower() for resultado in resultados):
        print("Flujo 3: Búsqueda válida - PASÓ")
    else:
        print("Flujo 3: Búsqueda válida - FALLÓ")
except Exception as e:
    capturar("error_busqueda_valida")
    print(f"Flujo 3: Búsqueda válida - FALLÓ: {e}")

# Flujo 4: Realizar una búsqueda sin resultados
try:
    print("Realizando una búsqueda sin resultados...")
    campo_busqueda.clear()
    campo_busqueda.send_keys("usuario_inexistente")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, "//td[contains(text(), 'No se encontraron resultados')]")))
    capturar("busqueda_sin_resultados")
    print("Flujo 4: Búsqueda sin resultados - PASÓ")
except Exception as e:
    capturar("error_busqueda_sin_resultados")
    print(f"Flujo 4: Búsqueda sin resultados - FALLÓ: {e}")

# Finalizo la prueba cerrando el navegador
driver.quit()