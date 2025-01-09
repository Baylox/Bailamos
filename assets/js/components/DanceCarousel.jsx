import React, { useEffect, useState } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Pagination } from "swiper/modules"; // Modules pour la navigation et la pagination
import "swiper/css"; // Styles de base de Swiper
import "swiper/css/navigation"; // Pour la navigation
import "swiper/css/pagination"; // Pour la pagination

const CourseCarousel = () => {
  const [courses, setCourses] = useState([]); // Stockage des cours
  const [loading, setLoading] = useState(true); // Gestion du chargement
  const [error, setError] = useState(null); // Gestion des erreurs

  // Récupération des données via l'API
  useEffect(() => {
    fetch("/api/courses")
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Erreur HTTP : ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        setCourses(data);
        setLoading(false);
      })
      .catch((err) => {
        setError(err.message);
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <p>Chargement des cours...</p>; 
  }

  if (error) {
    return <p>Erreur : {error}</p>; 
  }

  return (
    <Swiper
      className="carousel-container"
      modules={[Navigation, Pagination]}
      navigation
      pagination={{ clickable: true }}
      spaceBetween={40}
      slidesPerView={1}
      initialSlide={2} // Slide initial au milieu
      breakpoints={{
        640: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
      }}
    >
      {courses.map((course) => (
        <SwiperSlide key={course.id}>
          <div
            className="course-card"
            style={{
              backgroundImage: `url(${course.dance.image})`, // Image dynamique
            }}
            data-dance={course.dance.name}
          >
            <div className="course-overlay">
              <h3>{course.title}</h3>
              <p><strong>Type de danse :</strong> {course.dance.name}</p>
              <p><strong>Heure :</strong> {course.time}</p>
              <p><strong>Jour :</strong> {course.day_of_week}</p>
              <p><strong>Durée :</strong> {course.duration} minutes</p>
            </div>
          </div>
        </SwiperSlide>
      ))}
    </Swiper>
  );
};

export default CourseCarousel;




