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
    capturar("estudiante_ingresando_email")
    driver.find_element(By.NAME, "password").send_keys("123", Keys.RETURN)
    capturar("estudiante_ingresando_password")
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar("estudiante_login")
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
    capturar("modal_cerrado")

    # Accedo al icono de notificaciones
    bell = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.CSS_SELECTOR, "li.nav-item.dropdown > a.nav-link[data-toggle='dropdown']"))
    )
    bell.click()
    capturar("dropdown_abierto_inicial")

    # Cuento las notificaciones iniciales
    initial_items = driver.find_elements(By.CSS_SELECTOR, ".dropdown-menu .dropdown-item")
    count_before = len(initial_items)
    print(f"Cantidad de notificaciones iniciales: {count_before}")
    capturar("conteo_notificaciones_iniciales")

    # Cierro el menu desplegable de notificaciones
    bell.click()
    capturar("dropdown_cerrado_inicial")
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
    capturar("logout_estudiante")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("profesor@gmail.com")
    capturar("profesor_ingresando_email")
    driver.find_element(By.NAME, "password").send_keys("123", Keys.RETURN)
    capturar("profesor_ingresando_password")
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar("profesor_login")
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
    capturar("acceso_formulario_tareas")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "titulo")))
    driver.find_element(By.NAME, "titulo").send_keys(f"TareaNotif {int(time.time())}")
    capturar("llenando_titulo_tarea")
    driver.find_element(By.NAME, "descripcion").send_keys("Prueba notificacion")
    capturar("llenando_descripcion_tarea")
    driver.execute_script("document.getElementsByName('fecha_entrega')[0].value = '2025-12-31'")
    capturar("llenando_fecha_entrega")
    driver.execute_script("document.getElementsByName('hora_entrega')[0].value = '23:59'")
    capturar("llenando_hora_entrega")
    driver.find_element(By.XPATH, "//button[contains(text(),'Guardar Tarea')]").click()
    capturar("enviando_formulario_tarea")
    WebDriverWait(driver, 10).until(lambda d: "admin/tareas" in d.current_url)
    capturar("tarea_guardada_profesor")
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
    capturar("logout_profesor")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("estudiante@gmail.com")
    capturar("estudiante_reingresando_email")
    driver.find_element(By.NAME, "password").send_keys("123", Keys.RETURN)
    capturar("estudiante_reingresando_password")
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar("estudiante_relogin")
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
    capturar("modal_cerrado_final")

    # Accedo al icono de notificaciones
    bell = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.CSS_SELECTOR, "li.nav-item.dropdown > a.nav-link[data-toggle='dropdown']"))
    )
    bell.click()
    capturar("dropdown_abierto_final")

    # Cuento las notificaciones finales
    final_items = driver.find_elements(By.CSS_SELECTOR, ".dropdown-menu .dropdown-item")
    count_after = len(final_items)
    print(f"Cantidad de notificaciones finales: {count_after}")
    capturar("conteo_notificaciones_finales")

    # Cierro el menu desplegable de notificaciones
    bell.click()
    capturar("dropdown_cerrado_final")

    # Valido si las notificaciones aumentaron
    if count_after >= count_before + 1:
        print("Flujo 6: Verificacion de notificaciones finales - PASO")
    else:
        print("Flujo 6: Verificacion de notificaciones finales - FALLO: No aumento el conteo")
except Exception as e:
    capturar("error_verificacion_notificaciones_finales")
    print(f"Flujo 6: Verificacion de notificaciones finales - FALLO: {e}")

# Finalizo la prueba cerrando el navegador
driver.quit()