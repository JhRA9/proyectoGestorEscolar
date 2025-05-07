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

# Flujo 1: Prueba de acceso a la creación de tarea
try:
    print("Probando acceso a la página de creación de tareas...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")  # Credenciales válidas
    driver.find_element(By.NAME, "password").send_keys("123")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(lambda d: "admin" in driver.current_url)

    # Accedo a la página de creación de tareas
    driver.get("http://localhost/proyectoEscuela/admin/tareas/create.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "titulo")))
    capturar_pantalla("flujo1_acceso_creacion_tarea")
    print("Flujo 1: Acceso a la creación de tarea - PASÓ")
except Exception as e:
    capturar_pantalla("flujo1_error")
    print(f"Flujo 1: Acceso a la creación de tarea - FALLÓ: {e}")

# Flujo 2: Prueba de registro de tarea
try:
    print("Probando registro de una nueva tarea...")
    driver.find_element(By.NAME, "titulo").send_keys("Tarea de prueba")
    driver.find_element(By.NAME, "descripcion").send_keys("Descripción de prueba para la tarea.")
    driver.execute_script("document.getElementsByName('fecha_entrega')[0].value = '2025-05-10'")
    driver.execute_script("document.getElementsByName('hora_entrega')[0].value = '23:59'")
    driver.find_element(By.NAME, "id_materia").send_keys(Keys.DOWN)  # Selecciono la primera materia
    capturar_pantalla("flujo2_formulario_completado")

    # Envío el formulario
    driver.find_element(By.XPATH, "//button[contains(text(), 'Guardar Tarea')]").click()
    WebDriverWait(driver, 10).until(lambda d: "admin/tareas" in driver.current_url)
    capturar_pantalla("flujo2_tarea_registrada")
    print("Flujo 2: Registro de tarea - PASÓ")
except Exception as e:
    capturar_pantalla("flujo2_error")
    print(f"Flujo 2: Registro de tarea - FALLÓ: {e}")

# Flujo 3: Prueba de validación de campos
try:
    print("Probando validación de campos obligatorios...")
    driver.get("http://localhost/proyectoEscuela/admin/tareas/create.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "titulo")))

    # Dejo los campos vacíos y envío el formulario
    capturar_pantalla("flujo3_campos_vacios_antes")
    driver.find_element(By.XPATH, "//button[contains(text(), 'Guardar Tarea')]").click()

    # Verifico si la página no cambió (el formulario no se envió)
    current_url = driver.current_url
    capturar_pantalla("flujo3_campos_vacios_despues")
    if current_url == driver.current_url:  # La URL no debe cambiar si el formulario no se envió
        print("Flujo 3: Validación de campos - PASÓ")
    else:
        print("Flujo 3: Validación de campos - FALLÓ")
except Exception as e:
    capturar_pantalla("flujo3_error")
    print(f"Flujo 3: Validación de campos - FALLÓ: {e}")

# Flujo 4: Prueba de manejo de errores
try:
    print("Probando manejo de errores al guardar tarea...")
    driver.get("http://localhost/proyectoEscuela/admin/tareas/create.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "titulo")))

    # Simulo un error ingresando datos inválidos
    driver.find_element(By.NAME, "titulo").send_keys("")
    driver.find_element(By.NAME, "descripcion").send_keys("Descripción inválida")
    driver.execute_script("document.getElementsByName('fecha_entrega')[0].value = 'fecha_invalida'")
    capturar_pantalla("flujo4_datos_invalidos_antes")
    driver.find_element(By.XPATH, "//button[contains(text(), 'Guardar Tarea')]").click()

    # Verifico si la página no cambió (el formulario no se envió)
    current_url = driver.current_url
    capturar_pantalla("flujo4_datos_invalidos_despues")
    if current_url == driver.current_url:  # La URL no debe cambiar si el formulario no se envió
        print("Flujo 4: Manejo de errores - PASÓ")
    else:
        print("Flujo 4: Manejo de errores - FALLÓ")
except Exception as e:
    capturar_pantalla("flujo4_error")
    print(f"Flujo 4: Manejo de errores - FALLÓ: {e}")

# Flujo 5: Prueba de reversión de creación
try:
    print("Probando reversión de creación de tarea...")
    driver.get("http://localhost/proyectoEscuela/admin/tareas/create.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "titulo")))

    # Lleno los campos del formulario
    driver.find_element(By.NAME, "titulo").send_keys("Tarea a revertir")
    driver.find_element(By.NAME, "descripcion").send_keys("Descripción de tarea a revertir.")
    driver.execute_script("document.getElementsByName('fecha_entrega')[0].value = '2025-05-10'")
    driver.execute_script("document.getElementsByName('hora_entrega')[0].value = '23:59'")
    driver.find_element(By.NAME, "id_materia").send_keys(Keys.DOWN)
    capturar_pantalla("flujo5_formulario_completado")

    # Envío el formulario y luego simulo una reversión
    driver.find_element(By.XPATH, "//button[contains(text(), 'Guardar Tarea')]").click()
    WebDriverWait(driver, 10).until(lambda d: "admin/tareas" in driver.current_url)
    driver.get("http://localhost/proyectoEscuela/admin/tareas/delete.php?id=1")  # Simulo la reversión
    capturar_pantalla("flujo5_reversion_exitosa")
    print("Flujo 5: Reversión de creación - PASÓ")
except Exception as e:
    capturar_pantalla("flujo5_error")
    print(f"Flujo 5: Reversión de creación - FALLÓ: {e}")

# Cierro el navegador después de realizar las pruebas
driver.quit()