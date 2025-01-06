import React, { useEffect, useState } from "react";

const CourseList = () => {
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Appel de l'API pour récupérer les cours
    fetch('/api/courses')
      .then(response => response.json())
      .then(data => {
        setCourses(data);
        setLoading(false);
      })
      .catch(error => console.error('Erreur lors du chargement des cours:', error));
  }, []);

  if (loading) {
    return <p>Chargement des cours...</p>;
  }

  return (
    <div>
      <h2>Liste des cours</h2>
      <ul>
        {courses.map(course => (
          <li key={course.id}>
            <h3>{course.title}</h3>
            <p>
              Heure : {course.time} <br />
              Durée : {course.duration} minutes <br />
              Type de danse : {course.dance} <br />
              Jour : {course.day_of_week} <br />
            </p>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default CourseList;

