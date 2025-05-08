from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os
import time

# Configuro el navegador para realizar las pruebas
driver = webdriver.Chrome()
driver.maximize_window()
driver.get("http://localhost/proyectoEscuela/login/index.php")

# Creo una carpeta para guardar capturas de pantalla
if not os.path.exists("Capturas de pantalla"):
    os.makedirs("Capturas de pantalla")

# Defino una funcion para capturar pantallas durante la ejecucion de la prueba
def capturar(nombre):
    driver.save_screenshot(f"Capturas de pantalla/{nombre}.png")

# Inicio sesion como estudiante y verifico las notificaciones iniciales
try:
    print("Inicio sesion como estudiante...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("estudiante@gmail.com")
    capturar("01_estudiante_ingresando_email")
    driver.find_element(By.NAME, "password").send_keys("123", Keys.RETURN)
    capturar("02_estudiante_ingresando_password")
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar("03_estudiante_login")
    print("Flujo 1: Inicio de sesion como estudiante - PASO")
except Exception as e:
    capturar("error_inicio_sesion_estudiante")
    print(f"Flujo 1: Inicio de sesion como estudiante - FALLO: {e}")
    driver.quit()
    exit()

# Verifico las notificaciones iniciales
try:
    print("Verifico las notificaciones iniciales...")

    # Espero a que el modal de SweetAlert desaparezca
    WebDriverWait(driver, 10).until(
        EC.invisibility_of_element_located((By.CSS_SELECTOR, ".swal2-container"))
    )
    capturar("04_modal_cerrado")

    # Accedo al icono de notificaciones
    bell = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.CSS_SELECTOR, "li.nav-item.dropdown > a[data-toggle='dropdown']"))
    )
    bell.click()
    capturar("05_dropdown_abierto_inicial")

    # Cuento las notificaciones iniciales
    initial_count = int(bell.find_element(By.CSS_SELECTOR, ".badge").text)
    print(f"Cantidad de notificaciones iniciales: {initial_count}")
    capturar("06_conteo_notificaciones_iniciales")

    # Cierro el menu desplegable de notificaciones
    bell.click()
    capturar("07_dropdown_cerrado_inicial")
    print("Flujo 2: Verificacion de notificaciones iniciales - PASO")
except Exception as e:
    capturar("error_verificacion_notificaciones_iniciales")
    print(f"Flujo 2: Verificacion de notificaciones iniciales - FALLO: {e}")
    driver.quit()
    exit()

# Inicio sesion como profesor y creo una tarea
try:
    print("Inicio sesion como profesor para crear una tarea...")
    driver.get("http://localhost/proyectoEscuela/login/logout.php")
    capturar("08_logout_estudiante")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("profesor@gmail.com")
    capturar("09_profesor_ingresando_email")
    driver.find_element(By.NAME, "password").send_keys("123", Keys.RETURN)
    capturar("10_profesor_ingresando_password")
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar("11_profesor_login")
    print("Flujo 3: Inicio de sesion como profesor - PASO")
except Exception as e:
    capturar("error_inicio_sesion_profesor")
    print(f"Flujo 3: Inicio de sesion como profesor - FALLO: {e}")
    driver.quit()
    exit()

# Creo una tarea
try:
    print("Creo una tarea...")
    driver.get("http://localhost/proyectoEscuela/admin/tareas/create.php")
    capturar("12_acceso_formulario_tareas")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "titulo"))).send_keys(f"TareaNotif {int(time.time())}")
    capturar("13_llenando_titulo_tarea")
    driver.find_element(By.NAME, "descripcion").send_keys("Test integracion notificacion")
    capturar("14_llenando_descripcion_tarea")
    driver.execute_script("document.getElementsByName('fecha_entrega')[0].value='2025-12-31'")
    capturar("15_llenando_fecha_entrega")
    driver.execute_script("document.getElementsByName('hora_entrega')[0].value='23:59'")
    capturar("16_llenando_hora_entrega")
    driver.find_element(By.XPATH, "//button[contains(text(),'Guardar Tarea')]").click()
    capturar("17_enviando_formulario_tarea")
    WebDriverWait(driver, 10).until(lambda d: "admin/tareas" in d.current_url)
    capturar("18_tarea_guardada")
    print("Flujo 4: Creacion de tarea - PASO")
except Exception as e:
    capturar("error_creacion_tarea")
    print(f"Flujo 4: Creacion de tarea - FALLO: {e}")
    driver.quit()
    exit()

# Inicio sesion como estudiante y verifico las notificaciones finales
try:
    print("Inicio sesion como estudiante para verificar las notificaciones...")
    driver.get("http://localhost/proyectoEscuela/login/logout.php")
    capturar("19_logout_profesor")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("estudiante@gmail.com")
    capturar("20_estudiante_reingresando_email")
    driver.find_element(By.NAME, "password").send_keys("123", Keys.RETURN)
    capturar("21_estudiante_reingresando_password")
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar("22_estudiante_relogin")
    print("Flujo 5: Inicio de sesion como estudiante - PASO")
except Exception as e:
    capturar("error_reinicio_sesion_estudiante")
    print(f"Flujo 5: Inicio de sesion como estudiante - FALLO: {e}")
    driver.quit()
    exit()

# Verifico las notificaciones finales
try:
    print("Verifico las notificaciones finales...")

    # Espero a que el modal de SweetAlert desaparezca
    WebDriverWait(driver, 10).until(
        EC.invisibility_of_element_located((By.CSS_SELECTOR, ".swal2-container"))
    )
    capturar("23_modal_cerrado_final")

    # Accedo al icono de notificaciones
    bell = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.CSS_SELECTOR, "li.nav-item.dropdown > a[data-toggle='dropdown']"))
    )
    bell.click()
    capturar("24_dropdown_abierto_final")

    # Cuento las notificaciones finales
    final_count = int(bell.find_element(By.CSS_SELECTOR, ".badge").text)
    print(f"Cantidad de notificaciones finales: {final_count}")
    capturar("25_conteo_notificaciones_finales")

    # Valido si las notificaciones aumentaron
    if final_count >= initial_count + 1:
        print("Flujo 6: Verificacion de notificaciones finales - PASO")
    else:
        print("Flujo 6: Verificacion de notificaciones finales - FALLO: No aumento el conteo")
except Exception as e:
    capturar("error_verificacion_notificaciones_finales")
    print(f"Flujo 6: Verificacion de notificaciones finales - FALLO: {e}")

# Finalizo la prueba cerrando el navegador
driver.quit()